<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NewsController;




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

Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],function()
{
    Route::prefix('admin')->group(function(){

    Route::get('/login',[AuthController::class, 'login'])->name('dashboard.auth.login');
    Route::post('/do-login',[AuthController::class, 'doLogin'])->name('dashboard.auth.doLogin');


        Route::middleware('adminAuth:admin')->group(function () {
            Route::get('/logout', [AuthController::class, 'logout'])->name('dashboard.auth.logout');
            Route::get('/', [HomeController::class, 'index'])->name('dashboard.index');
            Route::resource('category',CategoryController::class);
            Route::resource('admins',AdminController::class);
            Route::resource('roles',RoleController::class);
            Route::resource('permissions', PermissionController::class);
            Route::resource('users', UserController::class);
            Route::resource('news', NewsController::class);


        });

});

});

