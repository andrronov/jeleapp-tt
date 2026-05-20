<?php

use App\Http\Controllers\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::post("/registration", [AuthApiController::class, "registration"]);
Route::middleware("auth:sanctum")->get("/profile", [
    AuthApiController::class,
    "profile",
]);
