<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\Loans;
use App\Http\Controllers\backend\Home;
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
Auth::routes();

Route::get('/',[Home::class,'index'])->name('home');
Route::middleware('is_admin')->group(function () {
    Route::get('/getLoans',[Loans::class,'getLoans'])->name('getLoans');
    Route::get('/changeStatus/{load_id}/{status}',[Loans::class,'changeStatus'])->name('changeStatus');
});

