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
        $viewMenu;
    	$success = true;
    	$viewMenus = json_encode($request->input('_menus'));

        $template = Auth::user()->templates->find($template_id);
        $templateViewMenus = $template->htmlviewmenus;

    	foreach (json_decode($viewMenus) as $key => $value)
    	{
            $viewMenu = $templateViewMenus->where('menu_title', $value->menuTitle)->first();
            $menuExists = $viewMenu->count() == 1;
    		if($menuExists)
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
    				return response()->json(compact('message', 'success', 'template_id', 'templateViewMenus'));
		    	} 			
    		}
    	}
		$message = 'All ' . collect(json_decode($viewMenus))->count() . ' template menus are created successfully!';
    	return response()->json(compact('message', 'success', 'templateViewMenus'));
    }
}
