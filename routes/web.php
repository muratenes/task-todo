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

//Route::get('/', function () {
//
//    $service = new \App\Library\Services\TodoService\ToDoService();
//    $service->updateTasks([
//        new \App\Library\Services\TodoService\Providers\FirstProvider(),
//        new \App\Library\Services\TodoService\Providers\SecondProvider(),
//    ]);
//
//    return view('welcome');
//});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/works', [\App\Http\Controllers\HomeController::class, 'works']);
