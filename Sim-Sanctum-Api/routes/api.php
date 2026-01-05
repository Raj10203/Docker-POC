<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DroneController;
use App\Http\Controllers\API\InspectionController;
use App\Http\Controllers\API\SiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // SiteController CRUD routes
    Route::get('/sites', [SiteController::class, 'index']);
    Route::post('/sites', [SiteController::class, 'store']);
    Route::get('/sites/{site}', [SiteController::class, 'show']);
    Route::put('/sites/{site}', [SiteController::class, 'update']);
    Route::delete('/sites/{site}', [SiteController::class, 'destroy']);
});

// Drone CRUD
Route::get('/drones', [DroneController::class, 'index']);
Route::post('/drones', [DroneController::class, 'store']);
Route::get('/drones/{drone}', [DroneController::class, 'show']);
Route::put('/drones/{drone}', [DroneController::class, 'update']);
Route::delete('/drones/{drone}', [DroneController::class, 'destroy']);

// Inspection CRUD
Route::get('/inspections', [InspectionController::class, 'index']);
Route::post('/inspections', [InspectionController::class, 'store']);
Route::get('/inspections/{inspection}', [InspectionController::class, 'show']);
Route::put('/inspections/{inspection}', [InspectionController::class, 'update']);
Route::delete('/inspections/{inspection}', [InspectionController::class, 'destroy']);


