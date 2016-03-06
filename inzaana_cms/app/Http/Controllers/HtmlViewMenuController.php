<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as HtmlViewMenuRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

use Inzaana\HtmlViewMenu;
use Auth;

class HtmlViewMenuController extends Controller
{
    //
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contents(HtmlViewMenuRequest $request, $template_id)
    {
        $success = true;
        $message = 'All contents are served.';
        $htmlViewMenus = Auth::user()->templates->find($template_id)->htmlviewmenus;
        if($htmlViewMenus->count() == 0)
        {
            $success = false;
            $message = 'No menu exists for the template!';
            return response()->json(compact('message', 'success'));
        }
        $menuContents = [];
        foreach ($htmlViewMenus as $key => $menu) 
        {
            $menuContents[$menu->menu_title] = $menu->content ? $menu->content->content_html : $request->input('_default_content');
        }
        if(collect($menuContents)->count() == 0)
        {
            $success = false;
            $message = 'No content exists for the template!';
            return response()->json(compact('message', 'success'));
        }
        return response()->json(compact('message', 'success', 'menuContents'));
    }

    // called from ... 
    // - savePage.js > updatePage()
    // - savePage.js > insertPage()
    public function create(HtmlViewMenuRequest $request, $template_id)
    {
    	$success = true;
    	$viewMenus = json_encode($request->input('_menus'));

        $template = Auth::user()->templates->find($template_id);
        if(!$template)
        {
            $success = false;
            $message = 'FATAL ERROR: INVALID TEMPLATE!';
            return response()->json(compact('message', 'success'));
        }
        // For the first time saving of a template it has no menus initially,
        // So below collection will be empty - which is expected
        $templateViewMenus = $template->htmlviewmenus;
        $hasMenus = $templateViewMenus->count() > 0;

    	foreach (json_decode($viewMenus) as $key => $value)
    	{            
            $viewMenu = $templateViewMenus->where('menu_title', $value->menuTitle)->first();
    		if($hasMenus && $viewMenu)
    		{
    			$viewMenu->menu_title = $value->menuTitle;
    			// $viewMenu->href = $value->aHref;
    			$viewMenu->save();
    		}
    		else
    		{
				$htmlViewMenu = HtmlViewMenu::create([
				       'template_id' => $template_id,
				       'menu_title' => $value->menuTitle,
				       // 'href' => $value->aHref,
				]);   
		    	if(!$htmlViewMenu)
		    	{
		    		$success = false;
		    		$message = 'Failed to create view menus';
    				return response()->json(compact('message', 'success', 'template_id'));
		    	} 			
    		}
    	}
		$message = 'All ' . collect(json_decode($viewMenus))->count() . ' template menus are created successfully!';
    	return response()->json(compact('message', 'success'));
    }
}
