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

    public function create($template_id)
    {
    	$success = true;
    	$viewMenus = session('viewMenus');
    	$viewMenu;
    	foreach (json_decode($viewMenus) as $key => $value)
    	{
    		$template = Auth::user()->templates()->find($template_id);
    		$viewMenu = $template->htmlViewMenus->where('menu_title', $value->menuTitle);
    		$menuExists = $viewMenu->count() == 1;
    		if($menuExists)
    		{
    			$viewMenu->menu_title = $value->menuTitle;
    			// $viewMenu->href = $value->aHref;
    			// $viewMenu->save();
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
		$message = 'Total ' . collect(json_decode($viewMenus))->count() . ' template menus are created successfully!';
		session(compact('message', 'success'));
    	return response()->json(compact('message', 'success'));
    }
}
