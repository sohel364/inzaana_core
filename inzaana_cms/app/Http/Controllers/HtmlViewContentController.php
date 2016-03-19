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
        if(!$request->has('_menus'))
        {
            return $this->responseWithflashError('FATAL ERROR: Empty menu list.');
        }
        $viewMenus = json_encode($request->input('_menus'));
        if(!$request->has('_menu_contents'))
        {
            return $this->responseWithflashError('FATAL ERROR: Empty contents list.');
        }
        $viewMenuContents = $request->input('_menu_contents');

        if(!$request->has('_menu_contents_edited'))
        {
            return $this->responseWithflashError('FATAL ERROR: Empty array of edited menu collection.');
        }
        $editedMenus = $request->input('_menu_contents_edited');
        
        if(!$request->has('_template_id'))
        {
            return $this->responseWithflashError('ERROR: No template ID found for the content.');
        }
        $template = Auth::user()->templates->find($request->input('_template_id'));
        if(!$template)
        {
            return $this->responseWithflashError('ERROR: the template does not exist!');
        }

    	foreach (json_decode($viewMenus) as $key => $value)
    	{
            $defaultContent = $request->has('_default_content') ? 
                                $request->input('_default_content') : 
                                '<div class="alert alert-danger">An empty content!</div>';
      
            $menuEditedExists= collect($editedMenus)->has($value->menuTitle);
            if($menuEditedExists && $editedMenus[$value->menuTitle] == false)
            {
                continue;
            }
            $menuContentExists = collect($viewMenuContents)->has($value->menuTitle);

            if($menuContentExists)
            {
                $viewMenusMatched = $template->htmlviewmenus->where('menu_title', $value->menuTitle);
                if(!$viewMenusMatched || $viewMenusMatched->count() == 0)
                {
                    return $this->responseWithflashError('ERROR: menu (' . $value->menuTitle . ') does not exist');
                }
                $content = $viewMenusMatched->first()->content;
                if($content)
                {
                    $content->content_html = $viewMenuContents[$value->menuTitle];
                    if(!$content->save())
                    {
                        return $this->responseWithflashError('ERROR: Failed to save view contents for menu (' . $value->menuTitle . ')');
                    }
                }
                else
                {
                    $htmlViewContent = HtmlViewContent::create([
                           'html_view_menu_id' => $viewMenusMatched->first()->id,
                           'content_html' => $viewMenuContents[$value->menuTitle],
                    ]);

                    if(!$htmlViewContent)
                    {
                        return $this->responseWithflashError('ERROR: Failed to save view contents for menu (' . $value->menuTitle . ')');
                    }
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
