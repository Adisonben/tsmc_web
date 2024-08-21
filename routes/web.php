<?php

use App\Http\Controllers\AppData\CarController;
use App\Http\Controllers\AppData\CarTypeController;
use App\Http\Controllers\AppData\PrefixController;
use App\Http\Controllers\Organization\OrgController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// App data
Route::resource('prefixes', PrefixController::class);
Route::resource('car-types', CarTypeController::class);


Route::resource('organizations', OrgController::class);
Route::post('/organizations/update/{organization}', [OrgController::class, 'update'])->name('org.update');
