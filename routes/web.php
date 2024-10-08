<?php

use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\AppData\CarTypeController;
use App\Http\Controllers\AppData\LicenseTypeController;
use App\Http\Controllers\AppData\PrefixController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FileUploadController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'storeHistory'])->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// App data
Route::resource('prefixes', PrefixController::class)->middleware('auth');
Route::resource('car-types', CarTypeController::class)->middleware('auth');


Route::resource('organizations', OrgController::class)->middleware('auth');
Route::post('/organizations/update/{organization}', [OrgController::class, 'update'])->name('org.update')->middleware('auth');
Route::post('/organizations/store/branch', [OrgController::class, 'storeBranch'])->name('org.store.brn')->middleware('auth');
Route::post('/organizations/update/branch/{brnId}', [OrgController::class, 'updateBranch'])->name('org.update.brn')->middleware('auth');
Route::delete('/organizations/delete/branch/{brnId}', [OrgController::class, 'destroyBranch'])->name('org.delete.brn')->middleware('auth');

Route::post('/organizations/store/department', [OrgController::class, 'storeDepartment'])->name('org.store.dpm')->middleware('auth');
Route::post('/organizations/update/department/{dpmId}', [OrgController::class, 'updateDepartment'])->name('org.update.dpm')->middleware('auth');
Route::delete('/organizations/delete/department/{dpmId}', [OrgController::class, 'destroyDepartment'])->name('org.delete.dpm')->middleware('auth');


Route::resource('positions', PositionController::class)->middleware('auth')->middleware('auth');
Route::post('/positions/update-data/{position}', [PositionController::class, 'update'])->name('positions.update.post')->middleware('auth');
Route::get('/position-permission/manage', [PositionController::class, 'managePermission'])->name('posit.perm')->middleware('auth');
Route::get('/position-permission/update/{positId}/{permId}/{status}', [PositionController::class, 'updatePermission'])->name('posit.perm.update')->middleware('auth');


Route::resource('users', UserController::class)->middleware('auth');
Route::get('/users/{user}/edit-my-profile', [UserController::class, 'editByOwn'])->name('users.editByOwn')->middleware('auth');
Route::get('/user-list/export', [UserController::class, 'exportUsers'])->name('user.list.export')->middleware('auth');
Route::post('/users/store-image', [UserController::class, 'storeImage'])->name('users.store.image')->middleware('auth');


Route::resource('driver-license-types', LicenseTypeController::class)->middleware('auth');


Route::resource('cars', CarController::class)->middleware('auth');
Route::post('/cars/update-data/{car}', [CarController::class, 'update'])->name('cars.update.post')->middleware('auth');


Route::resource('posts', PostController::class)->middleware('auth');
Route::post('/posts/comment', [PostController::class, 'storeComment'])->name('posts.comment')->middleware('auth');
Route::post('/posts/update/{post}', [PostController::class, 'update'])->name('posts.getUpdate')->middleware('auth');
Route::delete('/posts/comment/{id}', [PostController::class, 'delComment'])->name('posts.comment.delete')->middleware('auth');

Route::resource('forms', FormController::class)->middleware('auth');
Route::get('/forms/table/verify-form', [FormController::class, 'verifyFormTable'])->name('form.table.verify_form')->middleware('auth');
Route::get('/forms/table/{formtype}', [FormController::class, 'showFormTable'])->name('forms.tables')->middleware('auth');
Route::delete('/forms/table/form/{formid}', [FormController::class, 'destroy'])->name('forms.tables.delete')->middleware('auth');
Route::post('/forms/update/{formid}', [FormController::class, 'update'])->name('form.update.data')->middleware('auth');

Route::get('/form/checking/type', [FormController::class, 'checkingType'])->name('form.checking.type')->middleware('auth');
Route::get('/form/checking/{formid}', [FormController::class, 'checkingForm'])->name('form.checking')->middleware('auth');
Route::post('/form/checked/store', [FormController::class, 'storeCheckedForm'])->name('form.checked.store')->middleware('auth');
Route::get('/form/table/type', [FormController::class, 'tableType'])->name('form.table.type')->middleware('auth');
Route::get('/form/table/{formid}', [FormController::class, 'tableForm'])->name('form.table')->middleware('auth');
Route::get('/form/response/{formresid}/detail', [FormController::class, 'formResDetail'])->name('form.detail')->middleware('auth');
Route::get('/form/report/{formresid}', [FormController::class, 'formReport'])->name('form.report')->middleware('auth');
Route::get('/formtable/{fcode}', [FormController::class, 'tableNotHasForm'])->name('formtype.table')->middleware('auth');
Route::post('/form/phone-number/store', [FormController::class, 'storePhonenum'])->name('form.store.phonenum')->middleware('auth');

Route::get('/form/approve/{formresid}/{formresstatus}', [FormController::class, 'approveForm'])->name('form.approve')->middleware('auth');

Route::get('/form-types', [FormController::class, 'formType'])->name('form.types')->middleware('auth');
Route::post('/form-types/store', [FormController::class, 'formTypeStore'])->name('form.types.store')->middleware('auth');
Route::get('/form-types/delete/{ftid}', [FormController::class, 'formTypeDelete'])->name('form.types.delete')->middleware('auth');
Route::post('/form-types/update/{ftid}', [FormController::class, 'formTypeUpdate'])->name('form.types.update')->middleware('auth');

Route::post('/form/phone-number/{phonenumid}/update', [FormController::class, 'updatePhonenum'])->name('form.update.phonenum')->middleware('auth');
Route::delete('/phonenum/delete/{phonenumid}', [FormController::class, 'deletePhonenum'])->name('form.delete.phonenum')->middleware('auth');

// upload file route
Route::post('/posts/file-upload',[FileUploadController::class,'filepondUpload']);
Route::delete('/filepond/delete',[FileUploadController::class,'filepondDelete']);

Route::post('/form/daily-work/store', [FormController::class, 'storeDailyWork'])->name('form.store.dailywork')->middleware('auth');
Route::post('/form/daily-work/update/{fid}', [FormController::class, 'updateDailyWork'])->name('form.update.dailywork')->middleware('auth');
Route::get('/form/daily-work/delete/{fid}', [FormController::class, 'deleteDailyWork'])->name('form.delete.dailywork')->middleware('auth');

Route::post('/form/repair-emergency/store', [FormController::class, 'storeRepairEmerg'])->name('form.store.repair.emergency')->middleware('auth');
Route::post('/form/repair-emergency/update/{fid}', [FormController::class, 'updateRepairEmerg'])->name('form.update.repair.emergency')->middleware('auth');
Route::get('/form/repair-emergency/delete/{fid}', [FormController::class, 'deleteRepairEmerg'])->name('form.delete.repair.emergency')->middleware('auth');

Route::get('/formtable/repair-history/create', [FormController::class, 'createRepairHis'])->name('form.create.repair.history')->middleware('auth');
Route::get('/formtable/repair-history/delete/{fid}', [FormController::class, 'deleteRepairHis'])->name('form.delete.repair.history')->middleware('auth');
Route::get('/formtable/repair-history/detail/{fid}', [FormController::class, 'detailRepairHis'])->name('form.detail.repair.history')->middleware('auth');
Route::post('/formtable/repair-history/store', [FormController::class, 'storeRepairHis'])->name('form.store.repair.history')->middleware('auth');
Route::get('/get-car-details/{carId}', [CarController::class, 'getCarDetail'])->middleware('auth');

Route::get('/formtable/{formCode}/export', [ExportController::class, "exportData"])->name('form.export')->middleware('auth');
Route::get('/formtable/TSM-AI-004/search', [ExportController::class, "searchPhoneForm"]);
Route::get('/formtable/TSM-AI-005/search', [ExportController::class, "searchRepairEmerForm"]);
Route::get('/formtable/TSM-RP-002/search', [ExportController::class, "searchDailyWork"]);

Route::get('/formtable/TSM-RP-002/export/{fid}', [ExportController::class, "exportDailyWork"])->name('form.export.dairy.work');

Route::get('/formtable/TSM-V-002/search', [ExportController::class, "searchRepairHistory"]);
