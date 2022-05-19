<?php

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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Docs\DocsController;
use App\Http\Controllers\Docs\WelcomeController;

Route::get('/', [WelcomeController::class, 'welcome'])
    ->name('welcome');

Route::get('docs', [DocsController::class, 'index'])
    ->middleware(['hide.in-prod'])
    ->name('docs');

require __DIR__ . '/auth.php';
