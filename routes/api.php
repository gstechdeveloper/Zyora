<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
use App\Http\Controllers\Fornecedor;
use App\Http\Controllers\Materiais;
use App\Http\Controllers\Entrada;
use App\Http\Controllers\Requisicao;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/fornecedor/adicionar',[Fornecedor::class,"adicionar"])->middleware('auth:sanctum');

Route::post('/materiais/adicionar',[Materiais::class,"adicionar"])->middleware('auth:sanctum');

Route::post('/fornecedor/all',[Fornecedor::class,"selectAll"])->middleware('auth:sanctum');

Route::post('/entradas/all',[Entrada::class,"selectAll"])->middleware('auth:sanctum');

Route::post('/materiais/all',[Materiais::class,"selectAll"])->middleware('auth:sanctum');

Route::post('/entradas/all',[Entrada::class,"selectAll"])->middleware('auth:sanctum');

Route::post('/entradas/adicionar',[Entrada::class,"adicionar"])->middleware('auth:sanctum');

Route::post("/requisicoes/adicionar",[Requisicao::class, "add"])->middleware('auth:sanctum');

Route::post("/requisicoes/me",[Requisicao::class, "myRequests"])->middleware('auth:sanctum');

Route::post("/requisicoes/all",[Requisicao::class, "selectAll"])->middleware('auth:sanctum');

Route::post("/requisicoes/update",[Requisicao::class, "update"])->middleware('auth:sanctum');

Route::post('/materiais/select',[Materiais::class,"select"])->middleware('auth:sanctum');

Route::get('/fornecedor/edit/{id}',[Fornecedor::class,"edit"])->middleware('auth:sanctum');

Route::post('/fornecedor/selectName',[Fornecedor::class,"selectName"])->middleware('auth:sanctum');

Route::post('/entradas/delete',[Entrada::class,"delete"])->middleware('auth:sanctum');

Route::get('/materiais/edit/{id}',[Materiais::class,"edit"])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->post('/user/logout', [User::class, 'logout']);

Route::get('/requisicoes/edit/{id}',[Requisicao::class,"edit"])->middleware('auth:sanctum');

Route::post('/fornecedor/update',[Fornecedor::class,"update"])->middleware('auth:sanctum');

Route::post('/materiais/update',[Materiais::class,"update"])->middleware('auth:sanctum');

Route::post('/register',[User::class,"register"]);//->middleware('auth:sanctum');

Route::post('/login',[User::class,"login"]);



