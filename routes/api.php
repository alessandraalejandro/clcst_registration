<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainpageController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->get('/get-person', [MainpageController::class, 'getPerson']);
Route::middleware(['auth:sanctum'])->post('/edit-person', [MainpageController::class, 'editPerson']);
Route::middleware(['auth:sanctum'])->get('/get-person-access', [MainpageController::class, 'getPersonAccess']);
Route::middleware(['auth:sanctum'])->post('/edit-person-access', [MainpageController::class, 'editPersonAccess']);
Route::middleware(['auth:sanctum'])->get('/get-user-access/{id}', [MainpageController::class, 'getUserAccess']);

