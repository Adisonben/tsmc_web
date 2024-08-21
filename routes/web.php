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
Route::post('/organizations/store/branch', [OrgController::class, 'storeBranch'])->name('org.store.brn');
Route::post('/organizations/update/branch/{brnId}', [OrgController::class, 'updateBranch'])->name('org.update.brn');
Route::delete('/organizations/delete/branch/{brnId}', [OrgController::class, 'destroyBranch'])->name('org.delete.brn');

Route::post('/organizations/store/department', [OrgController::class, 'storeDepartment'])->name('org.store.dpm');
Route::post('/organizations/update/department/{dpmId}', [OrgController::class, 'updateDepartment'])->name('org.update.dpm');
Route::delete('/organizations/delete/department/{dpmId}', [OrgController::class, 'destroyDepartment'])->name('org.delete.dpm');
