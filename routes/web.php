<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Api\Client\AuthController as ClientAuthController;

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

Route::get('/', function(){
    return view('welcome');
});

//Admin Auth Routes
Route::group(['prefix' => 'admin', 'middleware' => ['guest'], 'as' => 'admin:'], function () {

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'login_attempt'])->name('login.action');
});

//Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin:'], function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    //Dashboard Routes
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //Users Routes
    Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('permission:view-users');
    Route::get('/user-create', [UserController::class, 'create'])->name('user.create')->middleware('permission:modify-users');
    Route::post('users/add', [UserController::class, 'store'])->name('user.add')->middleware('permission:modify-users');;
    Route::any('users/update/{id}', [UserController::class, 'update'])->name('user.update')->middleware('permission:modify-users');
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('permission:modify-users');
    Route::post('users/change_status', [UserController::class, 'change_status'])->name('user.status')->middleware('permission:change-status');
    Route::get('/user-destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('permission:delete-users');

    //Roles Routes
    Route::get('/roles', [RolesController::class, 'index'])->name('roles');
    Route::get('/role-create', [RolesController::class, 'create'])->name('role.create');
    Route::post('/role-add', [RolesController::class, 'store'])->name('role.add');
    Route::post('/roles/update/{id}', [RolesController::class, 'store'])->name('role.update');
    Route::get('/roles/edit/{id}', [RolesController::class, 'edit'])->name('role.edit');
    Route::get('roles/permission-modules/{id}', [RolesController::class, 'permission_modules'])->name('role.permission-modules');
    Route::post('roles/permission-modules/update/{id}', [RolesController::class, 'permission_modules_update'])->name('permissions-modules.update');
    Route::get('/role-destroy/{id}', [RolesController::class, 'destroy'])->name('role.destroy');
    Route::post('role/change_status', [RolesController::class, 'change_status'])->name('role.status');

    //Permissions Routes
    Route::get('permission/create', [PermissionsController::class, 'create'])->name('permission.create');
    Route::get('permissions', [PermissionsController::class, 'index'])->name('permissions');
    Route::get('permissions/edit/{id}', [PermissionsController::class, 'edit'])->name('permission.edit');
    Route::post('permissions/add', [PermissionsController::class, 'store'])->name('permissions.add');
    Route::any('permissions/update/{id}', [PermissionsController::class, 'store'])->name('permissions.update');
    Route::any('permissions/delete/{id}', [PermissionsController::class, 'destroy'])->name('permissions.delete');


    //Question CRUD Routes
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions');
    Route::get('/question-create', [QuestionController::class, 'create'])->name('question.create');
    Route::post('/question-add', [QuestionController::class, 'store'])->name('question.add');
    Route::get('/question/edit/{id}', [QuestionController::class, 'edit'])->name('question.edit');
    Route::post('/question/update/{id}', [QuestionController::class, 'store'])->name('question.update');
    Route::get('/question-destroy/{id}', [QuestionController::class, 'destroy'])->name('question.destroy');
    Route::post('question/change_status', [QuestionController::class, 'change_status'])->name('question.status');

    //Products CRUD Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/product-create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product-add', [ProductController::class, 'store'])->name('product.add');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'store'])->name('product.update');
    Route::get('/product-destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('product/change_status', [ProductController::class, 'change_status'])->name('product.status');

     //Customers CRUD Routes
     Route::get('/customers', [ClientAuthController::class, 'customers'])->name('customers');
     Route::post('customer/change_status', [ClientAuthController::class, 'change_status'])->name('customer.status');
});


