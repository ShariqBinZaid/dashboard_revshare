<?php

use App\Http\Controllers\ApiController;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\ClientController;
use App\Http\Controllers\Modules\ModulesController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\RentalAddonsController;
use App\Http\Controllers\RentalImagesController;
use App\Http\Controllers\RentalsController;
use App\Http\Controllers\RolePermission\RoleController;
use App\Http\Controllers\RolePermission\AttachController;
use App\Http\Controllers\RolePermission\RolePermissionController;
use App\Models\Rentals;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    echo "clear";
});

Route::get('/migratedatabase', function () {
    Artisan::call('migrate:fresh --seed');
});

Route::get('/clear/1', function () {
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
});

Auth::routes();
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/home', function () {
        return view('dashboard');
    })->name('dashboard.home');


    // ************************ Users  ************************ //
    Route::resource('user', UserController::class);
    Route::controller(UserController::class)->group(function () {
        Route::get('user/admin/lists', 'list')->name('user.admin.list');
        Route::get('user/admin/view/{id?}', function ($id) {
            $user = User::find($id);
            return view('Users.view')->with('user', $user);
        })->name('user.admin.view');
    });


    Route::resource('client', ClientController::class);
    Route::controller(ClientController::class)->group(function () {
        Route::get('user/client/lists', 'list')->name('user.client.list');
    });


    // ************************ Roles  ************************ //
    Route::resource('roles', RoleController::class);
    Route::controller(RolePermissionController::class)->group(function () {
        Route::get('/get-permission-to-role/{id?}', 'getpermissiontorole')->name('get.permission.role');
        Route::get('user/role/view/{id?}', 'index')->name('user.role.view');
        Route::get('user/role/list', 'list')->name('user.role.list');
        Route::DELETE('user/role/remove/{id?}', 'remove')->name('user.role.remove');
        Route::DELETE('role/destory/{id?}', 'destory')->name('role.destory');
    });


    // ************************ Modules  ************************ //
    Route::resource('module', ModulesController::class);
    Route::get('user/module/lists', [ModulesController::class, 'list'])->name('module.list');
    Route::post('storePermission',  [AttachController::class, 'storePermission'])->name('storePermission');


    // ************************ Rentals  ************************ //
    Route::resource('rentals', RentalsController::class);
    Route::controller(RentalsController::class)->group(function () {
        Route::get('user/rentals/lists', 'list')->name('rentals.list');
    });

    // ************************ Rentals Addons  ************************ //
    Route::resource('rentaladdons', RentalAddonsController::class);
    Route::controller(RentalAddonsController::class)->group(function () {
        Route::get('user/rentaladdons/lists', 'list')->name('rentaladdons.list');
    });

    // ************************ Rentals Images  ************************ //
    Route::resource('rentalimages', RentalImagesController::class);
    Route::controller(RentalImagesController::class)->group(function () {
        Route::get('user/rentalimages/lists', 'list')->name('rentalimages.list');
    });
});
