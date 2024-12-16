<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addToCart($productId, Request $request)
    {
        $quantity = $request->input('stock', 1);

        $this->cartRepository->addToCart($productId, $quantity);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $cart = $this->cartRepository->getCart();
        $totalCartItem = $this->cartRepository->getTotal();

        return view('cart.index', compact('cart', 'totalCartItem'));
    }

    public function removeFromCart($productId)
    {
        $this->cartRepository->removeFromCart($productId);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function checkout()
    {
        $cart = $this->cartRepository->getCart();
        $total = $this->cartRepository->getTotal();
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

        $this->cartRepository->createOrder($request);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}

