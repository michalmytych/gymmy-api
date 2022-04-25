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

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    fn () => view('welcome')
)->name('welcome');

Route::get(
    'docs',
    function () {
        $mdText = file_get_contents(
            docs_path() . '/setup-docker.md'
        );

        return view('docs.show', ['markdown' => $mdText]);
    }
)->name('docs');

require __DIR__ . '/auth.php';
