<?php

use App\Http\Controllers\Admin\ProductImagesController;

use App\Http\Controllers\Admin\ShipmentController;
use Illuminate\Support\Facades\Route;
/**
 * Admin Controllers
 */
use App\Http\Controllers\Admin\AuthController ;
use App\Http\Controllers\Admin\DashboardController ;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/**
 * Public Controllers
*/
use App\Http\Controllers\ProductController;


Route::get('/', fn () => redirect('/admin'));


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

        Route::resource('products', AdminProductController::class)->except('show')
        ->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
        Route::patch('products/{product}',[AdminProductController::class,'toggle'])->name('admin.products.toggle');

        Route::patch('product-images/{productImages}/{product}',[ProductImagesController::class, 'primary'])->name('product-image.primary');
        Route::delete('product-images/{productImages}',[ProductImagesController::class, 'destroy'])->name('product-image.destroy');

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


        Route::resource('orders',AdminOrderController::class)->only(['index','show','edit','update','destroy'])
        ->names([
            'index' => 'admin.orders.index',
            'show' => 'admin.orders.show',
            'edit' => 'admin.orders.edit',
            'update' => 'admin.orders.update',
            'destroy' => 'admin.orders.destroy',
        ]);


        Route::post('shipment/{order}',[ShipmentController::class,'store'])->name('admin.shipment.store');
        Route::delete('shipment/{order}',[ShipmentController::class,'destroy'])->name('admin.shipment.destroy');

    });
});
