<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as TemplateRequest;
use Illuminate\Http\Response;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Auth;

use Inzaana\Template;
use Inzaana\HtmlViewMenu as TemplateMenu;

class TemplateController extends Controller
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
    
    public function index()
    {
        //
        return view('view_template');
    }

    public function showSaved()
    {
        $message = 'Looks like you have no template to show. Let\'s create one from <a class="btn btn-primary btn-flat" href="' . route("user::templates") . '">Template Gallery</a>';
        $savedTemplates = Auth::user()->templates;
        $templatesCount = $savedTemplates->count();
        return view('my_template_view', compact('savedTemplates', 'templatesCount', 'message'));
    }

    // template view action for saving a new template
    public function browse($category, $template)
    {
        // TODO: check author
        $viewMenus = [];
        $viewData = [ 'category_name' => $category, 'template_name' => $template,
                'isEdit' => false, 'alert_type' => 'alert-info', 'viewMenus' => $viewMenus ];
        return view('editor.template-editor',  $viewData);
    }

    // template editor view for progressing a template edit action
    public function editor($category, $template, $template_id)
    {
        // TODO: check author
        $alert_type = 'alert-danger';
        $message = 'No contents found for the selected menu.';
        $category_name = $category;
        $template_name = $template;
        $template = Auth::user()->templates->find($template_id);
        if(!$template)
        {
            flash()->error('The saved " ' . $template_name . ' " template is not found!');
            return redirect()->route('user::templates');
        }
        $viewMenus = $template->htmlviewmenus;
        if($viewMenus->count() == 0)
        {
            flash()->error('The " ' . $template->saved_name . ' " template has no menus!');
            return redirect()->route('user::templates');
        }
        $isEdit = $viewMenus->count() > 0;

        return view('editor.template-editor', 
            compact('category_name', 'template_name', 'isEdit', 'template_id', 'message', 'alert_type', 'viewMenus') );
    }

    // template save action
    public function create(TemplateRequest $request)
    {
        if( $request->ajax() )
        {
            $success = true;

            session(['default_content' => $request->has('_default_content')]);

            // TODO: create a new Template
            $template = Template::create([
                'user_id' => Auth::user()->id,
                'saved_name' => $request->input('_saved_name'),
                'template_name' => $request->input('_template_name'),
                'category_name' => $request->input('_category_name'),
            ]);
            if(!$template)
            {
                $success = false;
                $message = 'Your template (' . $request->input('_saved_name') . ') is failed to save! Help: why template is not saved?';
                return response()->json(compact('success', 'message'));
            }
            $message = 'Congratulations! Your template (' . $template->saved_name . ') is saved successfully!';
            return response()->json(compact('success', 'message', 'template'));
        }
        return redirect()->route('user::templates');
    }

    public function show($template_id)
    {
        $template = Templates::all()->find($template_id);
        // TODO: do something to view
        return view('view_template', compact('template'));
    }

    public function categories($category_name)
    {
        return 'Show templates by categories';
    }

    // template edit action
    public function edit(TemplateRequest $request, $template_id)
    {
        if( $request->ajax() )
        {
            session(['default_content' => $request->has('_default_content')]);
            
            $template = Auth::user()->templates()->find($template_id);
            if(!$template)
            {
                $success = false;
                $message = 'No such template named (' . $request->input('_saved_name') . ') is found to modify! Please contact your admin for assistance.';
                return response()->json(compact('success', 'message'));
            }
            $template->saved_name = $request->input('_saved_name');

            $success = true;
            $message = 'Your template (' . $template->saved_name . ') is modified successfully!';
            if(!$template->save())
            {
                $success = false;
                $message = 'Your template (' . $request->input('_saved_name') . ') is failed to update! Help: why template is not modified?';
                return response()->json(compact('success', 'message'));
            }
            return response()->json(compact('success', 'message', 'template', 'jsonResponse'));
        }
        // TODO: do something to edit
        return redirect()->route('user::templates');
    }

    // get the template info
    public function info(TemplateRequest $request, $template_id)
    {
        if( $request->ajax() )
        {
            $success = true;
            $template = Auth::user()->templates()->find($template_id);
            if(!$template)
            {
                $success = false;
                $message = 'The requested template is not found!';
                return response()->json(compact('success', 'message'));
            }
            return response()->json(compact('template', 'message', 'success'));
        }
        return redirect()->route('user::templates');
    }
}
