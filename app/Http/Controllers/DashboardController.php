<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $products = Product::all(); // Fetch all products
        return view('dashboard', compact('products'));
    }
}
