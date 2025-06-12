<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\InventoryController;



//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

// Public Routes
Route::view('/', 'home')->name('home');
Route::get('products/showcase', [ProductController::class, 'showCase'])->name('products.showcase');
Route::get('orders/my', [OrderController::class, 'myOrders'])->name('orders.myOrders');
Route::post('orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::resource('orders', OrderController::class);

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');
Route::put('/cart/add-quantity/{id}', [CartController::class, 'addQuantity'])->name('cart.addQuantity');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::put('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/cart/remove-quantity/{id}', [CartController::class, 'removeQuantity'])->name('cart.removeQuantity');
Route::delete('/cart/clear', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm');
Route::post('/cart/processConfirm', [CartController::class, 'processConfirm'])->name('cart.processConfirm');

// Authorized Users
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::resource('users', UserController::class);
    Route::resource('settings', SettingController::class);
});

/*
//Member Routes
Route::middleware(['auth', 'member'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    //Routes Order
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'create', 'store']);

    //Routes Item Order
    Route::resource('itemsOrders', ItemsOrderController::class)->only(['index', 'show']);

    //Routes Product
    Route::resource('products', ProductController::class)->only(['index', 'show']);

    //Routes Setting
    Route::resource('settings', SettingController::class)->only(['index', 'show']);
});

//Board Member Routes
Route::middleware(['auth', 'board'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    //Routes User
    Route::resource('users', UserController::class)->only(['index', 'show']);

    //Routes Category
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);

    //Routes Order
    Route::resource('orders', OrderController::class)->only(['index', 'show']);

    //Routes Item Order
    Route::resource('itemsOrders', ItemsOrderController::class)->only(['index', 'show']);

    //Routes Product
    Route::resource('products', ProductController::class)->only(['index', 'show']);

    //Routes Setting
    Route::resource('settings', SettingController::class)->only(['index', 'show']);
});

// Employee Routes
Route::middleware(['auth', 'employee'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    //Routes User
    Route::resource('users', UserController::class)->only(['index', 'show']);

    //Routes Category
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);

    //Routes Order
    Route::resource('orders', OrderController::class)->only(['index', 'show']);

    //Routes Item Order
    Route::resource('itemsOrders', ItemsOrderController::class)->only(['index', 'show']);

    //Routes Product
    Route::resource('products', ProductController::class)->only(['index', 'show']);

    //Routes Setting
    Route::resource('settings', SettingController::class)->only(['index', 'show']);
});
*/

// Admin Routes
Route::middleware(['auth', 'is_employee_or_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');

    // encomenda especifica
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    
    // atualizar estado da encomenda
    Route::patch('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // gestão de invetário
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

    // encomendas de fornecimento
    Route::get('/supply-orders', [SupplyOrderController::class, 'index'])->name('supply-orders.index');
    Route::get('/supply-orders/create', [SupplyOrderController::class, 'create'])->name('supply-orders.create');
    Route::post('/supply-orders', [SupplyOrderController::class, 'store'])->name('supply-orders.store');
    Route::patch('/supply-orders/{supply_order}', [SupplyOrderController::class, 'update'])->name('supply-orders.update');
    Route::delete('/supply-orders/{supply_order}', [SupplyOrderController::class, 'destroy'])->name('supply-orders.destroy');

    // ajustes de stock
    Route::get('/inventory/adjust/{product}', [InventoryController::class, 'showAdjustmentForm'])->name('inventory.adjust.form');
    Route::post('/inventory/adjust/{product}', [InventoryController::class, 'storeAdjustment'])->name('inventory.adjust.store');
});

/*
Route::middleware(['auth', 'admin'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    //Routes User
    Route::resource('users', UserController::class);

    //Routes Category
    Route::resource('categories', CategoryController::class);

    //Routes Order
    Route::resource('orders', OrderController::class);

    //Routes Item Order
    Route::resource('itemsOrders', ItemsOrderController::class);

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
});*/


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


require __DIR__.'/auth.php';
