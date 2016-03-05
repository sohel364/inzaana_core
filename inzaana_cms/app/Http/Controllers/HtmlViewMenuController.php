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

    // called from client side ajax request when a menu title is clicked
    public function select($menu_title)
    {
        $success = true;
        $message = 'Menu ( ' . $menu_title . ' ) is selected.';
        session([ 'selected_menu_title' => $menu_title ]);
        return response()->json(compact('message', 'success'));
    }
}
