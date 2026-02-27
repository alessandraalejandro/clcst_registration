<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainpageController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->get('/get-person', [MainpageController::class, 'getPerson']);
Route::middleware(['auth:sanctum'])->post('/edit-person', [MainpageController::class, 'editPerson']);

