<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


Route::apiResource('user', UserController::class);


//handle not found route error
Route::fallback(function () {
    return response()->json([
        'status' => false,
        'message' => 'Page Not Found',
        'errors' => 'Page Not Found',
    ], 404);
});
