<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionsController;
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
    Route::post('customer/charges_status', [ClientAuthController::class, 'charges_status'])->name('customer.charges');

     //Filters CRUD Routes
    Route::get('/filters', [FilterController::class, 'index'])->name('filters');
    Route::get('/filter-create', [FilterController::class, 'create'])->name('filter.create');
    Route::post('/filter-add', [FilterController::class, 'store'])->name('filter.add');
    Route::get('/filter/edit/{id}', [FilterController::class, 'edit'])->name('filter.edit');
    Route::post('/filter/update/{id}', [FilterController::class, 'store'])->name('filter.update');
    Route::get('/filter-destroy/{id}', [FilterController::class, 'destroy'])->name('filter.destroy');
    Route::post('filter/change_status', [FilterController::class, 'change_status'])->name('filter.status');

    //Filters CRUD Routes
    Route::get('/addons', [AddonController::class, 'index'])->name('addons');
    Route::get('/addon-create', [AddonController::class, 'create'])->name('addon.create');
    Route::post('/addon-add', [AddonController::class, 'store'])->name('addon.add');
    Route::get('/addon/edit/{id}', [AddonController::class, 'edit'])->name('addon.edit');
    Route::post('/addon/update/{id}', [AddonController::class, 'store'])->name('addon.update');
    Route::get('/addon-destroy/{id}', [AddonController::class, 'destroy'])->name('addon.destroy');
    Route::post('addon/change_status', [AddonController::class, 'change_status'])->name('addon.status');

    
    //Orders Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/detail/{id}', [OrderController::class, 'detail'])->name('order.detail');
    Route::post('order/change_status', [OrderController::class, 'change_status'])->name('order.status');

       //Countries CRUD Routes
       Route::get('/countries', [CountryController::class, 'index'])->name('countries');
       Route::get('/country-create', [CountryController::class, 'create'])->name('country.create');
       Route::post('/country-add', [CountryController::class, 'store'])->name('country.add');
       Route::get('/country/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
       Route::post('/country/update/{id}', [CountryController::class, 'store'])->name('country.update');
       Route::get('/country-destroy/{id}', [CountryController::class, 'destroy'])->name('country.destroy');
       Route::post('country/change_status', [CountryController::class, 'change_status'])->name('country.status');

       //Categories CRUD Routes
       Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
       Route::get('/category-create', [CategoryController::class, 'create'])->name('category.create');
       Route::post('/category-add', [CategoryController::class, 'store'])->name('category.add');
       Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
       Route::post('/category/update/{id}', [CategoryController::class, 'store'])->name('category.update');
       Route::get('/category-destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
       Route::post('category/change_status', [CategoryController::class, 'change_status'])->name('category.status');

       //Settings Routes
       Route::get('/settings', [SettingController::class, 'index'])->name('settings');
       Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
});



