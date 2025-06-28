<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::name('entry.')->group(function () {
    Route::post("/entry/confirmation", [EntryController::class, 'confirmation'])->name('confirmation');
    Route::get('/entry/complete', [EntryController::class, 'complete'])->name('complete');
    Route::get("/", [EntryController::class, 'index'])->name('index');
    Route::post("/entry/store", [EntryController::class, 'store'])->name('store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/admin/export_csv/{type}', [AdminController::class, 'exportCsv'])->name('admin.csv');
    Route::get("/admin/dashboard", [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/delete_exported_forms', [AdminController::class, 'deleteExportedForms'])->name('admin.delete.exported.forms');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
