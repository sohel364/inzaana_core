<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as CategoryRquest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Inzaana\Category;

class CategoryController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the categories. get method
     * Show the form for creating a new category. get method
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all();
        return view('add-category', compact('categories'));
    }

    public function create(CategoryRquest $request)
    {    	
        $categories = Category::all();
        $categoryName = $request->input('category-name');
        $category = Category::create([
        	'sup_category_id' => 0,
        	'category_name' => $request->input('category-name'),
        	'category_slug' => str_slug($categoryName),
        	'description' => $request->input('description'),
        ]);
        return redirect()->route('user::categories')->with(compact('categories'));
    }

    public function edit($category_id)
    {
        # code...
        $categories = Category::all();
        return view('add-category', compact('categories'));
    }

    public function delete($category_id)
    {
        # code...
        $categories = Category::all();
        $category = $categories->find($category_id);
        if($category)
        {
            flash('Your category is will be removed when your administrator will approve.');
            $category->delete();
        }
        else
        {            
            flash('Your category is already removed or not in your list. Please contact your administrator to know category removal policy');
        }
        $categories = Category::all();
        return view('add-category', compact('categories'));
    }
}
