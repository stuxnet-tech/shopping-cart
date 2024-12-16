<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('impersonate/stop', [ImpersonationController::class, 'stop'])->name('impersonate.stop');

Route::middleware('auth')->group(function () 
{
    Route::middleware('role:admin,super_admin')->group(function () 
    {
        Route::resource('users', UserController::class);
        Route::get('products/upload', [ProductController::class, 'upload'])->name('products.upload');
        Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
        Route::get('download-sample', function () 
        {
            return response()->download(storage_path('app/public/products-sample.csv'));
        })->name('download.sample');

        Route::resource('products', ProductController::class);
    });

    Route::middleware('role:super_admin')->group(function () {
        Route::get('impersonate/{user}', [ImpersonationController::class, 'start'])->name('impersonate.start');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('cart/checkout/submit', [CartController::class, 'submitCheckout'])->name('cart.submitCheckout'); 

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show'); 
});


require __DIR__.'/auth.php';
