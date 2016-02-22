<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as TemplateRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Auth;

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
        return view('editor.template-editor', [ 'category' => $category, 'template_id' => $template ]);
    }

    public function create(TemplateRequest $request)
    {
        // TODO: create a new Template
        $template = Template::create();
        return view('view_template');
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
