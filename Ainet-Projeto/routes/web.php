<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemsOrderController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\SupplyOrderController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\SettingsShippingCostController;

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

Route::view('/', 'home')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::redirect('settings', 'settings/profile');

        Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
        Volt::route('settings/password', 'settings.password')->name('settings.password');
        Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    });


//Routes User
Route::resource('users', UserController::class);

//Routes Category
Route::resource('categories', CategoryController::class);

//Routes Order
Route::get('orders/showcase', [OrderController::class, 'showCase'])->name('orders.showcase');
Route::resource('orders', OrderController::class);

//Routes Item Order
Route::resource('itemsOrders', ItemsOrderController::class);

//Routes Product
Route::get('products/showcase', [ProductController::class, 'showCase'])->name('products.showcase');
Route::resource('products', ProductController::class);

//Routes Setting
Route::resource('settings', SettingController::class);

//Routes Setting Shipping Cost
Route::resource('settingsShippingCosts', SettingsShippingCostController::class);

//Routes Stock Adjustment
Route::resource('stockAdjustments', StockAdjustmentController::class);

//Routes Supply Order
Route::resource('supplyOrders', SupplyOrderController::class);

//Routes Operation
Route::resource('operations', OperationController::class);

//Routes Card
Route::resource('cards', CardController::class);

//Route Cart
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');
Route::put('/cart/add-quantity/{id}', [CartController::class, 'addQuantity'])->name('cart.addQuantity');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::put('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/remove-quantity/{id}', [CartController::class, 'removeQuantity'])->name('cart.removeQuantity');
Route::delete('/cart/clear', [CartController::class, 'destroy'])->name('cart.destroy');

require __DIR__.'/auth.php';
