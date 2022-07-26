<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RegisterController::class,'index'])->name('login');

Route::get('/login', [RegisterController::class,'index'])->name('login');

Route::get('/registerCompany', [RegisterController::class,'register'])->name('registerCompany');

Route::post('/registered', [RegisterController::class,'handleRegister'])->name('registered');

Route::post('/logged', [RegisterController::class,'handleLogin'])->name('logged');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Auth::routes();
