<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PetsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Storage;

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

// Show all Pets -- Visible for all users including not registered
Route::get('pets/{id?}', [PetsController::class, 'show']);

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    // Show current User
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        $user->profile_photo = Storage::url($user->profile_photo);
        return $user;
    });

    // Show all users
    Route::get('users/{id?}', [UserController::class, 'index']);

    // Update user by ID
    Route::put('user/{id}', [UserController::class, 'update']);

    // Soft Delete users
    Route::delete('user/{id}', [UserController::class, 'destroy']);


    // ------- Pets API

    // Create Pet
    Route::post('pets', [PetsController::class, 'store']);

    // Update pet by ID
    Route::put('pets/{id}', [PetsController::class, 'update']);

    // Soft Delete pets
    Route::delete('pets/{id}', [PetsController::class, 'destroy']);
});