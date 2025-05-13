<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\DepartmentController;

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


Route::get('courses/showcase', [CourseController::class, 'showCase'])->name('courses.showcase');

Route::resource('courses', CourseController::class);

Route::resource('disciplines', DisciplineController::class);

Route::resource('departments', DepartmentController::class);

require __DIR__.'/auth.php';
