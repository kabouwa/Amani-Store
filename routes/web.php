<?php


use Illuminate\Support\Facades\Route;
/**
 * Admin Controllers
*/
use App\Http\Controllers\Admin\AuthController ;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController ;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductImagesController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\PickupController;

/**
 * Public Controllers
*/
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

Route::get('/', fn() => to_route('products.index'));

/**
 * Admin Routes
*/
Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/',function(){
        return auth()->check()
            ? to_route('admin.dashboard')
            : to_route('admin.login');
    });

    Route::get('/login',[AuthController::class,'index'])->middleware('guest')->name('login');
    Route::post('/login/otp-verification',[AuthController::class,'verification'])->middleware('guest')->name('login.verification');
    Route::post('/login',[AuthController::class,'authenticate'])->middleware('guest');

    // Management Panel
    Route::middleware('auth')->group(function(){
        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

        Route::delete('/logout',[AuthController::class,'destroy'])->name('logout');

        Route::resource('users', UserController::class)->except('show');

        Route::patch('/users/{user}/password', [UserController::class,'updatePassword'])->name('users.password.update');

        Route::resource('products', AdminProductController::class)->except('show');

        Route::patch('products/{product}',[AdminProductController::class,'toggle'])->name('products.toggle');

        Route::patch('product-images/{productImages}/{product}',[ProductImagesController::class, 'primary'])->name('product-image.primary');

        Route::delete('product-images/{productImages}',[ProductImagesController::class, 'destroy'])->name('product-image.destroy');

        Route::resource('categories',AdminCategoryController::class)->except('show','create','edit');

        Route::resource('customers',AdminCustomerController::class)->only(['index','destroy']);

        Route::resource('orders',AdminOrderController::class)->except(['create','store']);

        Route::post('shipment/{order}',[ShipmentController::class,'store'])->name('shipment.store');
        
        Route::delete('shipment/{order}',[ShipmentController::class,'destroy'])->name('shipment.destroy');

        Route::resource('pickups',PickupController::class)->only('index','store','destroy');

    });
});


/**
 * Public Routes
*/
Route::resource('products',ProductController::class)->only(['index']);
Route::resource('orders',OrderController::class)->only(['create','store']);
Route::resource('categories',CategoryController::class)->only(['index','show']);