<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as HtmlViewContentRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

use Inzaana\HtmlViewMenu;
use Inzaana\HtmlViewContent;

class HtmlViewContentController extends Controller
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
    public function create(HtmlViewContentRequest $request)
    {
        $viewMenuContents;
    	$success = true;
        if(!$request->input('_menus'))
        {
            $success = false;
            $message = 'FATAL ERROR: Empty menu list.';
            return response()->json(compact('message', 'success'));
        }
        $viewMenus = json_encode($request->input('_menus'));
    	$viewMenuContents = $request->input('_menu_contents');
        if(!$viewMenuContents)
        {
            $success = false;
            $message = 'FATAL ERROR: Empty contents list.';
            return response()->json(compact('message', 'success'));
        }
    	
    	foreach (json_decode($viewMenus) as $key => $value)
    	{
    		// var_dump($value);
            $viewMenusMatched = HtmlViewMenu::where('menu_title', $value->menuTitle);
            if($viewMenusMatched->count() == 0)
            {
                $success = false;
                $message = 'FATAL ERROR: view menu of content is mismatched.';
                return response()->json(compact('message', 'success'));
            }
    		$content = $viewMenusMatched->first()->content;
    		if($content)
    		{
                if(collect($viewMenuContents)->has($value->menuTitle))
                {
                    $content->content_html = $viewMenuContents[$value->menuTitle];
                    $content->save();
                }
    		}
    		else
    		{
                if(collect($viewMenuContents)->has($value->menuTitle))
                {
                    $htmlViewContent = HtmlViewContent::create([
                           'html_view_menu_id' => $viewMenusMatched->first()->id,
                           'content_html' => $viewMenuContents[$value->menuTitle],
                    ]); 

                    if(!$htmlViewContent)
                    {
                        $success = false;
                        $message = 'ERROR: Failed to save view contents for menu (' . $value->menuTitle . ')';
                        return response()->json(compact('message', 'success'));
                    }
                }
    		}
    	}

        $selected_menu_title = collect(json_decode($viewMenus))->first()->menuTitle;
        session(compact('selected_menu_title'));

		$message = 'All ' . collect($viewMenuContents)->count() . ' contents are saved successfully!';
    	return response()->json(compact('message', 'success'));
    }
}
