<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Metadata\CategoryController;
use App\Http\Controllers\Admin\Metadata\SubCategoryController;
use App\Http\Controllers\Admin\GeneralController\PackageController;
use App\Http\Controllers\Admin\Metadata\ExperienceLevelController;
use App\Http\Controllers\Admin\Metadata\IndustryController;
use App\Http\Controllers\Admin\Metadata\SkillController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Only admin can access these routes
|
*/

Route::middleware(['web', 'admin.guest'])
    ->prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('login', 'index')->name('index');
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout');
    });


Route::middleware(['web', 'admin.auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('metadata')->name('metadata.')->group(function () {

        Route::prefix('industries')
            ->name('industries.')
            ->controller(IndustryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
            });
        Route::prefix('categories')
            ->name('categories.')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
            });
        Route::prefix('sub-categories')
            ->name('sub-categories.')
            ->controller(SubCategoryController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
            });
        Route::prefix('experience-levels')
            ->name('experience-levels.')
            ->controller(ExperienceLevelController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
            });
        Route::prefix('skills')
            ->name('skills.')
            ->controller(SkillController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
            });
    });

    Route::prefix('packages')->name('packages.')->controller(PackageController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/add', 'add')->name('add');
        Route::post('/store', 'store')->name('store');
    });
});
