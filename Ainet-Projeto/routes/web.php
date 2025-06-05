<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ItemOrderController;
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

//Routes Order
Route::resource('orders', OrderController::class);

//Routes Item Order
Route::resource('itemOrders', ItemOrderController::class);

//Routes Product
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

require __DIR__.'/auth.php';
