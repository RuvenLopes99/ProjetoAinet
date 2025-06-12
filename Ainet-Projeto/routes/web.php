<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Importação de todos os controladores necessários
use App\Http\Controllers\CardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemsOrderController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SettingsShippingCostController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\SupplyOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/
Route::view('/', 'home')->name('home');
Route::get('products/showcase', [ProductController::class, 'showCase'])->name('products.showcase');
Route::resource('products', ProductController::class)->only(['index', 'show']);


/*
|--------------------------------------------------------------------------
| Rotas do Carrinho de Compras (Cart)
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::put('/cart/add-quantity/{id}', [CartController::class, 'addQuantity'])->name('cart.addQuantity');
Route::patch('/cart/remove-quantity/{id}', [CartController::class, 'removeQuantity'])->name('cart.removeQuantity');
Route::put('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/confirm', [CartController::class, 'confirm'])->name('cart.confirm')->middleware('auth');
Route::post('/cart/processConfirm', [CartController::class, 'processConfirm'])->name('cart.processConfirm')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Rotas de Autenticação e Perfil
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', fn() => redirect()->route('settings.profile'));
        Volt::route('profile', 'settings.profile')->name('profile');
        Volt::route('password', 'settings.password')->name('password');
        Volt::route('appearance', 'settings.appearance')->name('appearance');
    });
});


/*
|--------------------------------------------------------------------------
| Área do Membro (Member Area)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:member,board'])->group(function () {
    Route::get('orders/showcase', [OrderController::class, 'showCase'])->name('orders.showcase');
    Route::resource('orders', OrderController::class)->only(['show', 'create', 'store']); // 'index' foi movido para Staff
    Route::prefix('member')->name('member.')->group(function () {
        Route::get('/card', [CardController::class, 'show'])->name('card.show');
    });
});


/*
|--------------------------------------------------------------------------
| Área de Staff (Funcionários e Administradores)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:employee,board'])->group(function() {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::resource('supplyOrders', SupplyOrderController::class);
    Route::resource('stockAdjustments', StockAdjustmentController::class);
});


/*
|--------------------------------------------------------------------------
| Área de Administração (Admin Panel - Apenas Board)
|--------------------------------------------------------------------------
| As URLs terão o prefixo /admin/, mas os nomes das rotas não (ex: 'categories.index')
| para corresponder ao que a sidebar espera.
*/
Route::middleware(['auth', 'role:board'])->prefix('admin')->group(function () {
    // A única rota que precisa do nome com prefixo, pois a sidebar assim o chama
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('admin.statistics.index');

    // As rotas de recursos agora não terão o prefixo 'admin.' no nome
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('cards', CardController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('operations', OperationController::class);
    Route::resource('itemsOrders', ItemsOrderController::class);
    Route::resource('settingsShippingCosts', SettingsShippingCostController::class);

    // Rotas de gestão que não são de um resource
    Route::patch('/users/{user}/block', [UserController::class, 'block'])->name('users.block');
    Route::patch('/users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');

    // Rotas de admin para encomendas (as que precisam do prefixo /admin/ na URL)
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});


/*
|--------------------------------------------------------------------------
| Rotas de Autenticação do Laravel
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
