<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request as CartRequest;

class ShoppingCart extends Model
{
    public static function get(CartRequest $request)
    {
        $cart_id = self::generateCartId($request);

        $cart = new ShoppingCart();
	    $cart->fingerprint = $cart_id;
        $cart->items_count = self::itemCount($cart_id);
        $items = self::items($cart_id);

        $groupedProducts = [];

        $products = collect($items)->unique('product_id')->values()->all();
        $grouped = collect($items)->groupBy('product_id');
        foreach($products as $item)
        {
            $item->quantity = $grouped->get($item->product_id)->count();
            $groupedProducts []= $item;
        }
        $cart->items = empty($groupedProducts) ? $items : $groupedProducts;
        // dd($cart->items);
		return $cart;
    }

    // destroys the cart
    public static function remove($cart_id)
    {
    	Redis::del($cart_id);
    	return !Redis::exists($cart_id);
    }

    public static function addItem($cart_id, array $item)
    {
    	$prevCount = self::itemCount($cart_id);
    	Redis::rpush($cart_id, collect($item)->toJson());
    	Redis::expire($cart_id, 60 * 5 /* 5 minutes */);
    	// stop the expire
    	// Redis::persist($cart_id);
    	return $prevCount < self::itemCount($cart_id);
    }

    public static function removeItem($cart_id, $product_id, $count = 1)
    {
    	$prevCount = self::itemCount($cart_id);
    	$item = self::itemExists($cart_id, $product_id);
    	if(!$item)
    		return false;
    	Redis::lrem($cart_id, $count, json_encode($item));
        Redis::expire($cart_id, 60 * 5 /* 5 minutes */);
    	return $prevCount > self::itemCount($cart_id);
    }

    public static function removeItems($cart_id, $product_id)
    {
    	return self::removeItem($cart_id, $product_id, 0);
    }

    // keeps the cart - removes items only
    public static function clear($cart_id)
    {
    	Redis::ltrim($cart_id, 0, self::itemCount($cart_id) - 1);
    	return self::isEmpty($cart_id);
    }

    public static function isEmpty($cart_id)
    {
    	return self::itemCount($cart_id) == 0;
    }

    public static function exists($cart_id)
    {
    	return Redis::exists($cart_id);
    }

    public static function items($cart_id)
    {
		$items = [];
        foreach(Redis::lrange($cart_id, 0, self::itemCount($cart_id) - 1) as $item)
        {
            $items []= json_decode($item);
        }
        return $items;
    }

    public static function itemCount($cart_id)
    {
        return Redis::llen($cart_id);
    }

    private static function generateCartId(CartRequest $request)
    {
        return 'cart:' . $request->ip() . ':id:' . $request->session()->getId();
    }

    // @returns mixed: boolean if failed | the item if passed
    private static function itemExists($cart_id, $product_id)
    {
    	for($index = 0; $index < self::itemCount($cart_id); ++$index)
    	{
    		$item = json_decode(Redis::lindex($cart_id, $index));
    		if($item->product_id == $product_id)
    			return $item;
    	}
    	return false;
    }
    public static function existInArray($cart_ids=null, $product_id=null){
        foreach($cart_ids as $cart){
            if($cart->product_id == $product_id){
                return true;
            }
        }
        return false;
    }
}
