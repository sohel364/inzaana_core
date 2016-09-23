<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as CategoryRquest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Inzaana\Category;

use Auth;

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
        // $categories = Category::all(); , compact('categories')
        return view('add-category')->withUser(Auth::user())
                                   ->withCategories(Category::all());
    }

    public function create(CategoryRquest $request)
    {
        $categoryName = $request->input('category-name');
        $category = Category::create([
        	'sup_category_id' => 0,
        	'category_name' => $request->input('category-name'),
        	'category_slug' => str_slug($categoryName),
        	'description' => $request->input('description'),
            'status' => 'ON_APPROVAL',
        ]);
        if($category)
        {
            flash('Your category (' . $category->category_name . ') is submitted for admin approval. Will be added when approved.');
        }
        else
        {
            flash('Your category (' . $category->category_name . ') is failed to submit for admin approval.');            
        }
        return redirect()->route('user::categories'); //->withCategories(Category::all());
    }

    public function edit($category_id)
    {
        # code...
        $categoryEdit = Category::find($category_id);
        $categories = Category::all();
        return view('add-category', compact('categories', 'categoryEdit'))->withUser(Auth::user());
    }

    public function postEdit(CategoryRquest $request, $category_id)
    {        
        $categories = Category::all();
        $categoryName = $request->input('category-name');
        $categoryEdit = Category::find($category_id);
        $categoryEdit->category_name = $categoryName;
        $categoryEdit->category_slug = str_slug($categoryName);
        $categoryEdit->description = $request->input('description');
        if($categoryEdit->update())
        {
            flash('Your category (' . $categoryEdit->category_name . ') is submitted for admin approval. Will be updated when approved.');
        }
        else
        {
            flash('Your category (' . $category->category_name . ') is failed to submit for admin approval.');            
        }
        return redirect()->route('user::categories');
    }

    public function delete($category_id)
    {
        # code...
        $categories = Category::all();
        $category = $categories->find($category_id);
        if($category)
        {
            flash('Your category (' . $category->category_name . ') is will be removed when your administrator will approve.');
            $category->delete();
        }
        else
        {            
            flash('Your category (' . $category->category_name . ') is already removed or not in your list. Please contact your administrator to know category removal policy');
        }
        return redirect()->route('user::categories');
    }

    public function approvals()
    {
        $categories = collect(Category::whereStatus('ON_APPROVAL')->orWhere('status', 'REJECTED')->orWhere('status', 'APPOVED')->get())->pluck( 'id', 'category_name' );
        $approvals = [
            'categories' => [
                'type' => Category::class,
                'data' => $categories
            ]
        ];
        return redirect()->route('user::products.approvals')->withApprovals($approvals);
    }
}
