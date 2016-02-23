<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as TemplateRequest;
use Illuminate\Http\Response;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Auth;

use Inzaana\Template;

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

    public function editor($category, $template)
    {
        // TODO: check author
        $isEdit = Template::all()->where('template_name', $template)->count();
        return view('editor.template-editor', 
            [ 'category_name' => $category, 'template_name' => $template, 'isEdit' => $isEdit ]);
    }

    public function create(TemplateRequest $request)
    {
        if( $request->ajax() )
        {
            // TODO: create a new Template
            $template = Template::create([
                'user_id' => Auth::user()->id,
                'saved_name' => $request->input('_saved_name'),
                'template_name' => $request->input('_template_name'),
                'category_name' => $request->input('_category_name'),
            ]);
            $success = true;
            $message = 'Congratulations! Your template (' . $template->saved_name . ') is saved successfully!';
            if(!$template)
            {
                $success = false;
                $message = 'Your template (' . $request->input('_saved_name') . ') is failed to save! Help: why template is not saved?';
                return response()->json(compact('success', 'message'));
            }
            return response()->json(compact('success', 'message', 'template'));
        }
        return view('editor.template-editor', 
            [ 'category_name' => $request->input('_category_name'), 'template_name' => $request->input('_template_name'), 'isEdit' => false ]);
    }

    public function show($template_id)
    {
        $template = Templates::all()->find($template_id);
        // TODO: do something to view
        return view('view_template', compact('template'));
    }

    public function edit($template_id)
    {
        $template = Templates::all()->find($template_id);
        // TODO: do something to edit
        return view('view_template', compact('template'));
    }
}
