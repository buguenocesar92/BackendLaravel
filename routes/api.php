<?php

use App\Http\Controllers\QueriesController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\LogRequests;



Route::get('/test', function () {
    return "el backend funciona correctamente";
});


Route::get("/backend", [BackendController::class, "getAll"]);

Route::get("/backend/{id?}", [BackendController::class, "index"]);

Route::post("/backend", [BackendController::class, "create"]);

Route::put("/backend/{id}", [BackendController::class, "update"]);

Route::delete("/backend/{id}", [BackendController::class, "delete"]);

Route::get("/query", [QueriesController::class, "get"]);

Route::get("/query/{id}", [QueriesController::class, "getById"]);

Route::get("/query/method/names", [QueriesController::class, "getNames"]);

Route::get("/query/method/search/{names}/{price}", [QueriesController::class, "searchName"]);

Route::get("/query/method/searchString/{value}", [QueriesController::class, "searchString"]);

Route::post("/query/method/advanceSearch", [QueriesController::class, "advanceSearch"]);

Route::get("/query/method/join", [QueriesController::class, "join"]);

Route::get("/query/method/groupby", [QueriesController::class, "GroupBy"]);

Route::apiResource("/products", ProductController::class)->only([
    'index', 'show', 'store', 'update', 'destroy'
])->middleware(["jwt.auth", LogRequests::class]);

Route::post("/register", [AuthController::class, "register"])->name("register");
Route::post("/login", [AuthController::class,"login"])->name( "login");

Route::middleware("jwt.auth")->group(function(){
    Route::get('who', [AuthController::class, 'who']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::get("/info/message", [InfoController::class, 'message']);
Route::get("/info/tax/{id}", [InfoController::class, 'iva']);
Route::get("/info/encrypt/{data}", [InfoController::class, 'encrypt']);
Route::get("/info/decrypt/{data}", [InfoController::class, 'decrypt']);
Route::get("/info/encryptEmail/{id}", [InfoController::class, 'encryptEmail']);
Route::get("/info/singleton", [InfoController::class, 'singleton']);
Route::get("/info/encryptEmail2/{id}", [InfoController::class, 'encryptEmail2']);