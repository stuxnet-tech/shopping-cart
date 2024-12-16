<?php

// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart
{
    public static function getCart()
    {
        return session()->get('cart', []);
    }

    public static function addToCart($product, $quantity)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;  
        } else {
            $cart[$product->id] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);  
    }

    public static function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);  
        }
        session()->put('cart', $cart);  
    }

    public static function getTotal()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['product']->price * $item['quantity'];
        }
        return $total;
    }
}

