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

    // returns default template menu contents
    public function baseContent(HtmlViewMenuRequest $request, $template_id)
    {
        $success = true;
        $message = 'Default contents are served.';
        $template = Auth::user()->templates->find($template_id);
        if($template)
        {
            flash()->info('ERROR: INVALIAD TEMPLATE!');
            return response()->view('flash', compact('message', 'success'))
                                ->header('Content-Type', 'html');;
        }
        return response()->view('includes.default-content', 
                                [ 'category_name' => $template->category_name, 'template_name' => $template->template_name ])
                        ->header('Content-Type', 'html');;
    }

    // returns reference collection of all contents of all menus
    public function contents(HtmlViewMenuRequest $request, $template_id)
    {
        $success = true;
        $message = 'All contents are served.';
        $template = Auth::user()->templates->find($template_id);
        if(!$template)
        {
            $success = false;
            $message = 'No such template exists!';
            return response()->json(compact('message', 'success'));
        }
        $htmlViewMenus = $template->htmlviewmenus;
        if($htmlViewMenus->count() == 0)
        {
            $success = false;
            $message = 'No menu exists for the template!';
            return response()->json(compact('message', 'success'));
        }
        $menuContents = [];
        $defaultContent = $request->has('_default_content') ? 
                            $request->input('_default_content') : 
                            '<div class="alert alert-danger">An empty content!</div>';
        foreach ($htmlViewMenus as $key => $menu) 
        {
            if($menu->content)
            {
                $menuContents[$menu->menu_title] = $menu->content->content_html;
            }
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

        $template = Auth::user()->templates->find($template_id);
        if(!$template)
        {
            return $this->responseWithflashError('FATAL ERROR: INVALID TEMPLATE!');
        }
        // For the first time saving of a template it has no menus initially,
        // So below collection will be empty - which is expected
        $templateViewMenus = $template->htmlviewmenus;
        $hasMenus = $templateViewMenus->count() > 0;

    	foreach (json_decode($viewMenus) as $key => $value)
    	{            
            $menuEditedExists= collect($editedMenus)->has($value->menuTitle);
            if($menuEditedExists && $editedMenus[$value->menuTitle] == false)
            {
                continue;
            }

            $menuContentExists = collect($viewMenuContents)->has($value->menuTitle);
            if($menuContentExists)
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
    	}
		$message = 'All ' . collect($viewMenuContents)->count() . ' template menus are created successfully!';
    	return response()->json(compact('message', 'success'));
    }

    protected function responseWithflashError($message)
    {
        $success = false;
        flash()->error($message);
        return response()->json(compact('message', 'success'));
    }
}
