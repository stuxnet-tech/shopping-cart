<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $products = Product::with('images')->get();
        return view('dashboard', compact('products'));
    }
}
