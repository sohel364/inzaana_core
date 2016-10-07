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
        return redirect()->route('user::categories');
    }

    public function edit($category_id)
    {
        # code...
        $categoryEdit = Category::find($category_id);
        $categories = Category::all();
        return view('add-category', compact('categories', 'categoryEdit'))->withUser(Auth::user());
    }

    public function postEdit(CategoryRequest $request, $category_id)
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
        $categories = collect(Category::whereStatus('ON_APPROVAL')->orWhere('status', 'REJECTED')->orWhere('status', 'APPROVED')->get())->pluck( 'id', 'category_name' );
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
        if($request->input('confirmation-select') == 'approve')
            $category->status = 'APPROVED';
        if($request->input('confirmation-select') == 'reject')
            $category->status = 'REJECTED';
        if(!$category->save())
            return redirect()->back()->withErrors(['Failed to confirm category approval!']);
        flash()->success('Your have ' . strtolower($category->getStatus()) . ' category (' . $category->category_name . ').');
        // Sends approval mail to users has a single product
        $data['type'] = Category::class;
        $data['status'] = $category->getStatus();
        $data['item_name'] = $category->category_name;
        $data['created_at'] = $category->created_at;
        foreach ($category->products->unique('user_id') as $product)
        {
            $mailer->sendEmailForApprovalNotificationTo($product->user, $data);
        }
        return redirect()->back();
    }
}
