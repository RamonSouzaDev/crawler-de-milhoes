<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/index', [Api::class, 'index'])->name('index');