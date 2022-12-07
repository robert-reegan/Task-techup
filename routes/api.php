<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);
Route::get('details', [ApiController::class, 'details']);


Route::group(['prefix' => 'task', 'middleware' => ['auth:sanctum']], function () use ($router) {

    $router->get('/', [TaskController::class, 'index']);
    $router->post('search', [TaskController::class, 'search'])->middleware('auth:sanctum');
    $router->post('add', [TaskController::class, 'store']);
});

Route::group(['prefix' => 'notes', 'middleware' => ['auth:sanctum']], function () use ($router) {
    $router->post('add', [NotesController::class, 'store']);
});
