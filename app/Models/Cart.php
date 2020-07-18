<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    const SHIPPING_PRICE = 5.90;

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function items()
    {
        return $this->hasMany('App\Models\CartItem');
    }

    public function getTotalQuantityAttribute()
    {
        $quantity = 0;

        foreach ($this->items as $item) {
            $quantity += $item->quantity;
        }

        return $quantity;
    }

    public function getItemsPriceAttribute()
    {
        $price = 0;

        foreach ($this->items as $item) {
            $price += $item->price;
        }

        return $price;
    }

    public function getItemsPriceFormattedAttribute()
    {
        return number_format($this->itemsPrice, 2, ',', ' ') . ' €';
    }

    public function getShippingPriceAttribute()
    {
        return self::SHIPPING_PRICE;
    }

    public function getShippingPriceFormattedAttribute()
    {
        return number_format($this->shippingPrice, 2, ',', ' ') . ' €';
    }

    public function getTotalPriceAttribute()
    {
        return $this->itemsPrice + $this->shippingPrice;
    }

    public function getTotalPriceFormattedAttribute()
    {
        return number_format($this->totalPrice, 2, ',', ' ') . ' €';
    }

    public static function check(Request $request)
    {
        if (! $request->session()->has('cart')) {
            return false;
        }

        $cart = $request->session()->get('cart');

        if (! Cart::where('id', $cart->id)->exists()) {
            return false;
        }

        return true;
    }

    public static function generateNewCartSession(Request $request)
    {
        $cart = new Cart();

        $cart->token = uniqid();
        $cart->isActive = true;

        if (Auth::check()) {
            $cart->customer_id = Auth::user()->id;
        }

        if ($request->session()->has('cart')) {
            $oldCart = $request->session()->get('cart');
            $cart->shipping_address_id = $oldCart->shipping_address_id;
            $cart->billing_address_id = $oldCart->billing_address_id;
        }

        $cart->save();
        session(['cart' => $cart]);
    }
    
    public static function updateCartSession(Request $request)
    {
        $cart = $request->session()->get('cart');

        $updatedCart = Cart::where('id', $cart->id)->first();

        session(['cart' => $updatedCart]);
    }
}
