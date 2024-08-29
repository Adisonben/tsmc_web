<?php

use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\AppData\CarTypeController;
use App\Http\Controllers\AppData\LicenseTypeController;
use App\Http\Controllers\AppData\PrefixController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Organization\CarController;
use App\Http\Controllers\Organization\OrgController;
use App\Http\Controllers\Organization\PositionController;
use App\Http\Controllers\PostController;
use App\Models\License_type;
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


Route::resource('positions', PositionController::class);
Route::post('/positions/update-data/{position}', [PositionController::class, 'update'])->name('positions.update.post');


Route::resource('users', UserController::class);
Route::get('/users/{user}/edit-my-profile', [UserController::class, 'editByOwn'])->name('users.editByOwn');
Route::post('/users/store-image', [UserController::class, 'storeImage'])->name('users.store.image');


Route::resource('driver-license-types', LicenseTypeController::class);


Route::resource('cars', CarController::class);
Route::post('/cars/update-data/{car}', [CarController::class, 'update'])->name('cars.update.post');


Route::resource('posts', PostController::class);
Route::post('/posts/comment', [PostController::class, 'storeComment'])->name('posts.comment');
Route::delete('/posts/comment/{id}', [PostController::class, 'delComment'])->name('posts.comment.delete');

Route::resource('forms', FormController::class);
Route::get('/forms/table/{formtype}', [FormController::class, 'showFormTable'])->name('forms.tables');
Route::delete('/forms/table/form/{formid}', [FormController::class, 'destroy'])->name('forms.tables.delete');
Route::post('/forms/update/{formid}', [FormController::class, 'update'])->name('form.update.data');

Route::get('/form/checking/type', [FormController::class, 'checkingType'])->name('form.checking.type');
Route::get('/form/checking/{formid}', [FormController::class, 'checkingForm'])->name('form.checking');
Route::post('/form/checked/store', [FormController::class, 'storeCheckedForm'])->name('form.checked.store');
Route::get('/form/table/type', [FormController::class, 'tableType'])->name('form.table.type');
Route::get('/form/table/{formid}', [FormController::class, 'tableForm'])->name('form.table');
Route::get('/form/response/{formresid}/detail', [FormController::class, 'formResDetail'])->name('form.detail');
