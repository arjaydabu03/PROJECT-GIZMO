<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\DepartmentController;

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

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::post("auth/logout", [AuthController::class, "logout"]);
    Route::patch("auth/archived/{id}", [AuthController::class, "destroy"]);
    Route::put("auth/{id}", [AuthController::class, "update"]);
    Route::apiResource("auth", AuthController::class);

    Route::patch("reset_password/{id}", [
        AuthController::class,
        "reset_password",
    ]);
    Route::patch("change_password/{id}", [
        AuthController::class,
        "change_password",
    ]);

    Route::post("role/validate", [RoleController::class, "validate_name"]);
    Route::patch("archive/{id}", [RoleController::class, "destroy"]);
    Route::apiResource("role", RoleController::class);

    Route::patch("archive/company/{id}", [CompanyController::class, "destroy"]);
    Route::apiResource("company", CompanyController::class);

    Route::patch("archive/department/{id}", [
        DepartmentController::class,
        "destroy",
    ]);
    Route::apiResource("department", DepartmentController::class);

    Route::patch("archive/location/{id}", [
        LocationController::class,
        "destroy",
    ]);
    Route::apiResource("location", LocationController::class);
});

Route::post("auth/login", [AuthController::class, "login"]);
