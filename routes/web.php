<?php

use App\Livewire\PageAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//Route::get('/admin', [PageAdmin::class])->name('admin.home');
Route::get('/admin', function () {return view('livewire.page-admin');})->name('admin.home');