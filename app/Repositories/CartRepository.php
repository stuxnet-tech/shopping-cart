<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartRepository
{
    public function addToCart($productId, $quantity)
    {
        $product = Product::findOrFail($productId);

        return Cart::addToCart($product, $quantity);
    }

    public function getCart()
    {
        return Cart::getCart();
    }

    public function getTotal()
    {
        return Cart::getTotal();
    }

    public function removeFromCart($productId)
    {
        return Cart::removeFromCart($productId);
    }

    public function createOrder($request)
    {
        $user = Auth::user();
        $cart = $this->getCart();
        $total = $this->getTotal();
        $gst = $total * 0.18;
        $grandTotal = $total + $gst;

        $order = Order::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total_amount' => $total,
            'tax' => $gst,
            'grand_total' => $grandTotal,
            'status' => 'Pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['product']->price,
                'total' => $item['quantity'] * $item['product']->price,
            ]);
        }

        session()->forget('cart');

        return $order;
    }
}
