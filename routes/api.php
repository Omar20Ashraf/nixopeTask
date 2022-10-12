<?php

use Illuminate\Support\Facades\Route;




//handle not found route error
Route::fallback(function () {
    return response()->json([
        'status' => false,
        'message' => 'Page Not Found',
        'errors' => 'Page Not Found',
    ], 404);
});
