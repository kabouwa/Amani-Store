<?php

use Illuminate\Support\Facades\Route;
/**
 * Admin Controllers
 */
use App\Http\Controllers\Admin\AuthController ;
use App\Http\Controllers\Admin\DashboardController ;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;

/**
 * Public Controllers
*/
use App\Http\Controllers\ProductController;



Route::prefix('admin')->group(function(){
    Route::get('/',function(){
        return auth()->check()
            ? to_route('admin.dashboard')
            : to_route('admin.login');
    });

    Route::get('/login',[AuthController::class,'index'])->middleware('guest')->name('admin.login');
    Route::post('/login',[AuthController::class,'authenticate'])->middleware('guest');

    // Management Panel
    Route::middleware('auth')->group(function(){
        Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');

        Route::delete('/logout',[AuthController::class,'destroy'])->name('admin.logout');

        Route::resource('products',AdminProductController::class)->only(['index','create','store'])
        ->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
        ]);

        Route::resource('categories',AdminCategoryController::class)->only(['index','store','update','destroy'])
        ->names([
            'index' => 'admin.categories.index',
            'store' => 'admin.categories.store',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destory',
        ]);

        Route::resource('customers',AdminCustomerController::class)->only(['index','destroy'])
        ->names([
            'index' => 'admin.customers.index',
            'destroy' => 'admin.customers.destroy',
        ]);
    });
});
