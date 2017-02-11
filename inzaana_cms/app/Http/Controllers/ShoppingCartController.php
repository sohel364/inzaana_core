<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request as CartRequest;

use Inzaana\Http\Requests;

use Inzaana\ShoppingCart as Cart;

use Redis;

use Inzaana\Store;
use Inzaana\Product;
use Redirect as StoreRedirect;

class ShoppingCartController extends Controller
{

    const CART_ID = 'cart:101';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function add(CartRequest $request, $name, $domain)
    {
    	$faker = \Faker\Factory::create();

    	$item = [ 'id' => $faker->unique()->randomDigit, 'title' => str_random(10), 'image_url' => $faker->imageUrl(50, 50, 'cats'), 'mrp' => $faker->unique()->randomFloat ];

    	$redis = Redis::connection();
    	
    	$cart_id = self::CART_ID;

    	$redis->rpush($cart_id, collect($item)->toJson());
		$item_count = $redis->llen($cart_id);

    	if($request->ajax())
    	{
    		if($request->has('cart_item'))
    		{
    			$item = $request->query('cart_item');
				$items = $redis->lrange($cart_id, 0, $item_count - 1);
				return response()->view('shopping-cart', [ 'cart' => [ 'cart_id' => $cart_id, 'item_count' => $item_count, 'items' => $items ] ])
				    					 ->header('Content-Type', 'html');
    		}
    	}
        return redirect()->route('guest::showcase', compact('name', 'domain'));
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

    	$faker = \Faker\Factory::create();
    	$cart_id = self::CART_ID;//'cart:' . $faker->unique()->randomDigit;
    	$redis = Redis::connection();
		$item_count = $redis->llen($cart_id);
		$items = $redis->lrange($cart_id, 0, $item_count - 1);
		if($item_count == 0)
		{
	        $cart = new Cart();
	        $cart->id = $cart_id;
	        $cart->items_count = 6; 
	        $cart->items = $items; 
		}
		else
		{			
	        $cart = new Cart();
	        $cart->items_count = $item_count; 
	        $cart->items = $items;
		}
        return view('store-showcase')->withProducts($store->user->products)
        							 ->withSubDomain($name . '.inzaana.' . $domain)
        							 ->withStoreNameUrl($name)
        							 ->withCart($cart);
        // return view('vendor-store')->withProducts($store->user->products)->withSubDomain($name . '.inzaana.' . $domain)->withStoreNameUrl($name);
    }
}
