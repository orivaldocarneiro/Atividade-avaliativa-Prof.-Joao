<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

Route::post('criarPost', [PostController::class, 'store']);

Route::post('listarPost', [PostController::class, 'index']);

Route::post('deletarPost/{id}', [PostController::class, 'destroy']);

Route::post('editarPost/{id}', [PostController::class, 'edit']);

Route::post('mostrarPost/{id}', [PostController::class, 'show']);

Route::post('criarComment/{id}/comentario', [CommentController::class,'store']);

Route::post('listarComment/{id}/comentario', [CommentController::class, 'index']);

Route::post('deletarComment/{id}/comentario/{id_comentario}', [CommentController::class, 'destroy']);

Route::post('editarComment/{id}/comentario/{id_comentario}', [CommentController::class, 'edit']);

Route::post('mostrarComment/{id}/comentario/{id_comentario}', [CommentController::class, 'show']);