<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\PersonalAccessToken;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/niaj', function () {
    return response()->json(['message' => 'Success']);
});

Route::post('/reg', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Inside routes/api.php on the Auth microservice
Route::post('/validate', function (Request $request) {
    if (!$request->has('token')) {
        return response()->json(['error' => 'Token is missing'], 400);
    }

    $user = PersonalAccessToken::findToken($request->token);

    if (!$user) {
        return response()->json(['error' => 'Invalid token'], 401);
    }

    return response()->json(['user_id' => $user->tokenable_id]);
});

