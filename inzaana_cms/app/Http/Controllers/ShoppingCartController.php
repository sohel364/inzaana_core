<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as CartRequest;

use Inzaana\Http\Requests;

use Inzaana\ShoppingCart as Cart;

use Redis;

use Inzaana\Store;
use Inzaana\Product;
use Inzaana\MarketProduct;
use Redirect as ShoppingCartRedirect;

/*
    @reference:
    - https://cartalyst.com/manual/cart/2.0#features
    - https://www.dunebook.com/5-ways-to-implement-shopping-cart-in-laravel/10/
    - http://andremadarang.com/implementing-a-shopping-cart-in-laravel/
    - http://stackoverflow.com/questions/36234548/how-track-sessionid-for-shopping-cart-table-in-laravel    
    - http://squizzle.me/php/predis/doc/Commands#expire
 */

class ShoppingCartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('session');
    }

    public function index($name, $domain)
    {
        return ShoppingCartRedirect::to('http://inzaana.' . $domain . '/');
    }

    public function add(CartRequest $request, $name, $domain, $cart_id)
    {
    	if($request->ajax())
    	{
    		if($request->has('cart_item'))
    		{
                $item = $request->query('cart_item');

                $marketProduct = MarketProduct::find($item['product_id']);

                $item = [
                    'product_id' => $item['product_id'],
                    'cart_id' => $cart_id,
                    'title' => $item['title'],
                    'image_url' => $item['image_url'],
                    'mrp' => $item['price'],
                    'product_manufacturer' => $marketProduct ? $marketProduct->manufacturer_name : 'Unknown',
                    'product_status' => $marketProduct ? $marketProduct->product->getStatus() : 'Unknown',
                    'store_name' => $name,
                    'domain' => $domain
                ];
                $cart = Cart::findCart($cart_id);
                if(!Cart::addItem($cart->fingerprint, $item))
                {
                    flash()->error('Add item to cart is failed!');
                }
                $cart = Cart::findCart($cart_id);
                return response()->view('includes.shopping-cart', [ 'cart' => $cart, 'store_name' => $name, 'domain' => $domain ])->header('Content-Type', 'html');
    		}
    	}
        return redirect()->route('guest::showcase', compact('name', 'domain', 'cart_id'));
    }

    public function remove(CartRequest $request, $name, $domain, $cart_id, $product_id)
    {
        $cart = Cart::findCart($cart_id);

        if(!Cart::removeItem($cart->fingerprint, $product_id))
        {
            flash()->error('Remove item from cart is failed!');
        }
        $cart = Cart::findCart($cart_id);
        if($request->ajax())
        {
            // return 1;
            return response()->view('includes.shopping-cart', [ 'cart' => $cart, 'store_name' => $name, 'domain' => $domain ])->header('Content-Type', 'html');
        }
        return redirect()->route('guest::showcase', compact('name', 'domain', 'cart_id'));
    }

    public function removeFromCheckout(CartRequest $request, $name, $domain, $cart_id, $product_id)
    {
        $cart = Cart::findCart($cart_id);

        if(!Cart::removeItem($cart->fingerprint, $product_id))
        {
            flash()->error('Remove item from cart is failed!');
        }
        if($request->ajax())
        {
            return 1;
        }
        return redirect()->route('guest::cart.checkout', compact('name', 'domain', 'cart_id'));
    }

    public function redirectToStore(CartRequest $request, $name, $domain)
    {
        // return redirect()->route('guest::home');
        // return HomeRedirect::to('http://' . $site . '/');
        // return 'THIS IS PUBLIC PAGE (' . $name . '.inzaana.' . $domain . '/showcase) FOR VENDOR\'S STORE';

        $store = Store::whereNameAsUrl($name)->first();
        if(!$store)
            return abort(404);
            
        if($store->status == 'REJECTED')
            return response()->view('store-comingsoon', [], 404);
        else if($store->status == 'ON_APPROVAL')
            return view('store-comingsoon');

    	$cart = Cart::get($request);

        $paginatedProducts = $store->user->products()->paginate(4);
        $paginatedProducts->setPath('showcase');
        return view('store-showcase')->withProducts($store->user->products)
        							 ->withSubDomain($name . '.inzaana.' . $domain)
                                     ->withStoreEmail($store->user->email)
                                     ->withStoreOwner($store->user)
                                     ->withStoreName($name)
                                     ->withStoreNameTidy($store->name)
                                     ->withDomain($domain)
        							 ->withCart($cart)
                                     ->withPaginatedProducts($paginatedProducts);
    }

    public function redirectToCheckout(CartRequest $request, $name, $domain, $cart_id)
    {
        $store = Store::whereNameAsUrl($name)->first();
        if(!$store)
            return abort(404);
            
        if($store->status == 'REJECTED')
            return response()->view('store-comingsoon', [], 404);
        else if($store->status == 'ON_APPROVAL')
            return view('store-comingsoon');

        $cart = Cart::findCart($cart_id);

        if(empty($cart->items))
        {
            flash('Your shopping cart is empty!');
        }

        return view('product-chekcout')->withProducts($store->user->products)
                                       ->withSubDomain($name . '.inzaana.' . $domain)
                                       ->withStoreEmail($store->user->email)
                                       ->withStoreOwner($store->user)
                                       ->withStoreName($name)
                                       ->withStoreNameTidy($store->name)
                                       ->withDomain($domain)
                                       ->withCart($cart);
    }

    public function continueShopping(CartRequest $request, $name, $domain, $cart_id)
    {
        $store = Store::whereNameAsUrl($name)->first();
        if(!$store)
            return abort(404);
            
        if($store->status == 'REJECTED')
            return response()->view('store-comingsoon', [], 404);
        else if($store->status == 'ON_APPROVAL')
            return view('store-comingsoon');

        $viewData = [
            'products' => $store->user->products,
            'sub_domain' => $name . '.inzaana.' . $domain,
            'store_email' => $store->user->email,
            'store_owner' => $store->user,
            'store_name' => $name,
            'store_name_tidy' => $store->name,
            'domain' => $domain,
            'cart' => Cart::findCart($cart_id)
        ];
        return response()->view('store-showcase', $viewData);
    }
}
