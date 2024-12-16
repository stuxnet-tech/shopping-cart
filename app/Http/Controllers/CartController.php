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
    public function checkout()
    {
        $cart = Cart::getCart();
        $total = Cart::getTotal();
        $gst = $total * 0.18;
        $grandTotal = $total + $gst;
        
        return view('cart.checkout', compact('cart', 'total', 'gst', 'grandTotal'));
    }

    public function submitCheckout(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:COD',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        $user = Auth::user();
        $cart = Cart::getCart();
        $total = Cart::getTotal();
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

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}

