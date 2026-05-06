<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;

// ------------------------------------
// CUSTOMER ROUTES
// ------------------------------------
Route::get('/',[CustomerController::class, 'index'])->name('home');
Route::get('/add-to-cart/{id}', [CustomerController::class, 'addToCart'])->name('cart.add');
Route::get('/clear-cart', [CustomerController::class, 'clearCart'])->name('cart.clear');
Route::post('/place-order', [CustomerController::class, 'placeOrder'])->name('order.place');

Route::post('/cart/update/{id}', [CustomerController::class, 'updateQuantity'])->name('cart.update');
Route::get('/cart/remove/{id}', [CustomerController::class, 'removeItem'])->name('cart.remove');

// ------------------------------------
// ADMIN ROUTES
// ------------------------------------
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Order Actions
    Route::post('/order/{id}/complete',[AdminController::class, 'completeOrder'])->name('admin.order.complete');

    Route::delete('/admin/order/{id}/delete', [AdminController::class, 'deleteOrder'])->name('admin.order.delete');
    
    // Menu Management (CRUD)
    Route::get('/menu', [AdminController::class, 'menu'])->name('admin.menu');           // Read
    Route::post('/menu/store', [AdminController::class, 'storeMenu'])->name('admin.menu.store'); // Create
    
    // --- ADDED THIS LINE TO FIX THE 404 ERROR ---
    Route::put('/menu/update/{id}', [AdminController::class, 'updateMenu'])->name('admin.menu.update'); // Update
    
    
    Route::delete('/menu/{id}/delete', [AdminController::class, 'deleteMenu'])->name('admin.menu.delete'); // Delete
});


// ------------------------------------
// AUTHENTICATION ROUTES
// ------------------------------------
require __DIR__.'/auth.php';