<?php

use Illuminate\Support\Facades\Route;

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

Route::view('/', 'auth.login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('autocomplete/{action}', \App\Http\Controllers\AutocompleteController::class)->name('autocomplete');

    Route::resource('firms', \App\Http\Controllers\FirmController::class)->only(['index', 'create', 'edit']);
    Route::resource('firms.workers', \App\Http\Controllers\WorkerController::class)->only(['index', 'create', 'edit']);

    Route::group(['prefix' => 'firms/{firm}/workers/{worker}/prophylactic-checkups', 'as' => 'prophylactic-checkups.'], function () {
        Route::get('/', [\App\Http\Controllers\ProphylacticCheckupController::class, 'index'])->name('index');
        Route::get('{prophylactic_checkup}/edit/{tab?}', [\App\Http\Controllers\ProphylacticCheckupController::class, 'edit'])->name('edit');
        Route::get('create', [\App\Http\Controllers\ProphylacticCheckupController::class, 'create'])->name('create');
    });

    Route::group(['prefix' => 'firms/{firm}/workers/{worker}/patient-charts', 'as' => 'patient-charts.'], function () {
        Route::get('/', \App\Http\Controllers\PatientChartController::class)->name('index');
    });
});
