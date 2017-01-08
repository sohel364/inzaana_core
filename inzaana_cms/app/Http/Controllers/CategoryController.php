<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as CategoryRequest;

use Inzaana\Http\Requests;
use Inzaana\Http\Controllers\Controller;
use Inzaana\Category;
use Inzaana\Mailers\AppMailer;

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
        return view('add-category')->withUser(Auth::user())
                                   ->withCategories(Category::all());
    }

    public function create(CategoryRequest $request)
    {
        $categoryName = $request->input('category-name');
        $category = new Category();
        $category->parent_category_id = Category::ROOT_ID;
        $category->name = $request->input('category-name');
        $category->category_slug = str_slug($categoryName);
        $category->description = $request->input('description');
        if(!$category->save())
        {
            flash('Your category (' . $category->name . ') is failed to submit for admin approval.');
            return redirect()->back();
        }
        flash('Your category (' . $category->name . ') is submitted for admin approval. Will be added when approved.');
        return redirect()->route('user::categories');
    }

    public function edit($category_id)
    {
        $categoryEdit = Category::find($category_id);
        $categories = Category::all();
        return view('add-category', compact('categories', 'categoryEdit'))->withUser(Auth::user());
    }

    public function postEdit(CategoryRequest $request, $category_id)
    {
        $categoryName = $request->input('category-name');
        $categoryEdit = Category::find($category_id);
        $categoryEdit->name = $categoryName;
        $categoryEdit->category_slug = str_slug($categoryName);
        $categoryEdit->description = $request->input('description');
        if($categoryEdit->update())
        {
            flash('Your category (' . $categoryEdit->name . ') is submitted for admin approval. Will be updated when approved.');
        }
        else
        {
            flash('Your category (' . $category->name . ') is failed to submit for admin approval.');            
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
            flash('Your category (' . $category->name . ') is will be removed when your administrator will approve.');
            $category->delete();
        }
        else
        {            
            flash('Your category (' . $category->name . ') is already removed or not in your list. Please contact your administrator to know category removal policy');
        }
        return redirect()->route('user::categories');
    }

    public function approvals()
    {
        $categories = collect(Category::whereStatus('ON_APPROVAL')->orWhere('status', 'REJECTED')->orWhere('status', 'APPROVED')->get())->pluck( 'id', 'name' );
        $approvals = [
            'categories' => [
                'type' => Category::class,
                'data' => $categories
            ]
        ];
        return redirect()->route('user::products.approvals')->withApprovals($approvals);
    }

    public function confirmApproval(CategoryRequest $request, AppMailer $mailer, $id)
    {
        $category = Category::find($id);
        if(!$category)
            return redirect()->back()->withErrors(['Category not found to approve!']);
        if(!$request->has('confirmation-select'))
            return redirect()->back()->withErrors(['Invalid request of approval confirmation!']);

        switch($request->input('confirmation-select'))
        {
            case 'approve': 
                $category->status = 'APPROVED';
            case 'reject':
                $category->status = 'REJECTED';
            case 'remove':
                $category->status = 'REMOVED';
        }
        
        if(!$category->save())
            return redirect()->back()->withErrors(['Failed to confirm category approval!']);
        flash()->success('Your have ' . strtolower($category->getStatus()) . ' category (' . $category->name . ').');
        // Sends approval mail to users has a single product
        $data['type'] = Category::class;
        $data['status'] = $category->getStatus();
        $data['item_name'] = $category->name;
        $data['created_at'] = $category->created_at;
        foreach ($category->products->unique('user_id') as $product)
        {
            $mailer->sendEmailForApprovalNotificationTo($product->user, $data);
        }
        return redirect()->back();
    }
}
