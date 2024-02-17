<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function() {
    Route::get('/member', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/{status?}', [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/{status}/{member:name_slug}', [MemberController::class, 'detail'])->name('member.detail');
})->name('member');

Route::middleware('auth')->group(function() {
    Route::get('/salary', [SalaryController::class, 'index'])->name('salary.index');
    Route::get('/salary/calculate', [SalaryController::class, 'detail'])->name('salary.detail');
    Route::post('/salary/calculate', [SalaryController::class, 'calculate'])->name('salary.calculate');
})->name('salary');



require __DIR__.'/auth.php';
