<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Add product to cart.
     */
    public function addToCart($productId, Request $request)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('stock', 1);

        // Add to cart
        Cart::addToCart($product, $quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * View the cart.
     */
    public function index()
    {
        $cart = Cart::getCart();
        $totalCartItem = Cart::getTotal();
        return view('cart.index', compact('cart','totalCartItem'));
    }

    /**
     * Remove product from cart.
     */
    public function removeFromCart($productId)
    {
        Cart::removeFromCart($productId);
        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    /**
     * Checkout the cart and create an order.
     */
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        $user = Auth::user();
        $cart = Cart::getCart();
        $total = Cart::getTotal();
        $gst = $total * 0.18; // Apply 18% GST

        // Create an order
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total + $gst,
            'tax' => $gst,
            'status' => 'Pending',
        ]);

        // Save order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['product']->price,
            ]);
        }

        // Clear cart after successful order placement
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}

