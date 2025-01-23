<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Default route to display the welcome page
Route::get('/', function () {
    return view('welcome');
});

// Route to show the registration form
Route::get('/register', function () {
    return view('register');
});
