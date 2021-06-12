<?php

use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('/threads', [ThreadsController::class, 'index'])->name('threads');
Route::get('/threads/create', [ThreadsController::class, 'create'])->middleware('auth');
Route::get('/threads/{channel:slug}', [ThreadsController::class, 'index']);
Route::get('/threads/{channel:slug}/{thread}', [ThreadsController::class, 'show']);

Route::post('/threads', [ThreadsController::class, 'store'])->middleware('auth');
Route::post('/threads/{channel:slug}/{thread}/replies', [RepliesController::class, 'store'])->middleware('auth');
