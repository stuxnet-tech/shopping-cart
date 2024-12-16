<?php


namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        // Fetch orders for the logged-in user
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the details of a specific order.
     */
    public function show($id)
    {
        // Find the order by ID and ensure it belongs to the logged-in user
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
