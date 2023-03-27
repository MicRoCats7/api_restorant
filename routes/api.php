<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::delete('/logout', [AuthController::class, 'logout']);


Route::post('/menu/add', [MenuController::class, 'create']);
Route::post('/menu/update/{id}', [MenuController::class, 'update']);
Route::delete('/menu/delete/{id}', [MenuController::class, 'destroy']);

Route::post('/category/add', [CategoryController::class, 'create']);
Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);



Route::get('/menu', [MenuController::class, 'readAll']);
Route::get('/category', [CategoryController::class, 'getCategory']);
Route::get('/category/menu', [CategoryController::class, 'readMenu']);
Route::group(['middleware' => ['auth:sanctum']], function () {
});
