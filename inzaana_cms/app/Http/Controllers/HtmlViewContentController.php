<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as HtmlViewContentRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;

use Inzaana\HtmlViewMenu;
use Inzaana\HtmlViewContent;
use Auth;

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
            flash()->error($message);
            return response()->json(compact('message', 'success'));
        }
        $viewMenus = json_encode($request->input('_menus'));
    	$viewMenuContents = $request->input('_menu_contents');
        if(!$viewMenuContents)
        {
            $success = false;
            $message = 'FATAL ERROR: Empty contents list.';
            flash()->error($message);
            return response()->json(compact('message', 'success'));
        }
        if(!$request->has('_template_id'))
        {            
            $success = false;
            $message = 'ERROR: No template ID found for the content.';
            flash()->error($message);
            return response()->json(compact('message', 'success'));
        }
        $template = Auth::user()->templates->find($request->input('_template_id'));
        if(!$template)
        {
            return responseWithflashError('ERROR: the template does not exist!');
        }

    	foreach (json_decode($viewMenus) as $key => $value)
    	{
            $defaultContent = $request->has('_default_content') ? 
                                $request->input('_default_content') : 
                                '<div class="alert alert-danger">An empty content!</div>';

            $menuContentExists = collect($viewMenuContents)->has($value->menuTitle);

            $viewMenusMatched = $template->htmlviewmenus->where('menu_title', $value->menuTitle);
            if(!$viewMenusMatched)
            {
                return responseWithflashError('ERROR: menu does (' . $value->menuTitle . ') not exist');
            }
    		$content = $viewMenusMatched->first()->content;
    		if($content)
    		{
                $content->content_html = $menuContentExists ? $viewMenuContents[$value->menuTitle] : $defaultContent;
                if(!$content->save())
                {
                    return responseWithflashError('ERROR: Failed to save view contents for menu (' . $value->menuTitle . ')');
                }
            }
    		else
    		{
                $htmlViewContent = HtmlViewContent::create([
                       'html_view_menu_id' => $viewMenusMatched->first()->id,
                       'content_html' => $menuContentExists ? $viewMenuContents[$value->menuTitle] : $menuContentExists,
                ]);

                if(!$htmlViewContent)
                {
                    return responseWithflashError('ERROR: Failed to save view contents for menu (' . $value->menuTitle . ')');
                }
    		}
    	}

		$message = 'All ' . collect($viewMenuContents)->count() . ' contents are saved successfully!';
    	return response()->json(compact('message', 'success'));
    }

    protected function responseWithflashError($message)
    {
        $success = false;
        flash()->error($message);
        return response()->json(compact('message', 'success'));
    }
}
