<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\Admin\InventoryController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/
Route::view('/', 'home')->name('home');
Route::get('products/showcase', [ProductController::class, 'showCase'])->name('products.showcase');
Route::resource('products', ProductController::class)->only(['index', 'show']);

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');


/*
|--------------------------------------------------------------------------
| Rotas para Utilizadores Autenticados
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Perfil do Utilizador
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Confirmação do Carrinho (requer login)
    Route::post('/cart/processConfirm', [CartController::class, 'processConfirm'])->name('cart.processConfirm');

    /*
    |--------------------------------------------------------------------------
    | Área do Membro (Acessível a 'member' e 'board')
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:member,board')->group(function () {
        Route::get('orders/showcase', [OrderController::class, 'showCase'])->name('orders.showcase');
        Route::resource('orders', OrderController::class)->only(['show', 'create', 'store']);

        Route::prefix('member')->name('member.')->group(function () {
            Route::get('/card', [CardController::class, 'show'])->name('card.show');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | PAINEL DE GESTÃO (Acessível a 'employee' e 'board')
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:employee,board')->prefix('admin')->name('admin.')->group(function () {
        // Rotas de Gestão de Encomendas
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Rotas de Gestão de Inventário
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/adjust/{product}', [InventoryController::class, 'showAdjustmentForm'])->name('inventory.adjust.form');
        Route::post('/inventory/adjust/{product}', [InventoryController::class, 'storeAdjustment'])->name('inventory.adjust.store');
        Route::resource('supply-orders', SupplyOrderController::class)->except(['show']);
        Route::resource('stock-adjustments', StockAdjustmentController::class);

        /*
        |--------------------------------------------------------------------------
        | Área Exclusiva de Administradores ('board')
        |--------------------------------------------------------------------------
        */
        Route::middleware('role:board')->group(function () {
            Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

            // Gestão de Recursos
            Route::resource('products', ProductController::class);
            Route::resource('users', UserController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('cards', CardController::class);
            Route::resource('settings', SettingController::class);
            Route::resource('operations', OperationController::class);
            Route::resource('itemsOrders', ItemsOrderController::class);
            Route::resource('settingsShippingCosts', SettingsShippingCostController::class);

            // Ações Específicas
            Route::patch('/users/{user}/block', [UserController::class, 'block'])->name('users.block');
            Route::patch('/users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação do Laravel
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

