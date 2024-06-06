<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('students/{id}', [StudentController::class, 'index']);
Route::get('classes', [StudentController::class, 'classes']);
Route::get('dashboard', [StudentController::class, 'dashboard']);
Route::get('rollnos/{id}', [StudentController::class, 'rollnos']);
Route::post('students', [StudentController::class, 'store']);
Route::get('student/{id}', [StudentController::class, 'show']); 
Route::put('studentsupdate/{id}', [StudentController::class, 'update']);
Route::delete('studentdelete/{id}', [StudentController::class, 'destroy']);
Route::post('users', [AdminController::class, 'show']);
Route::put('changeusers/{id}', [AdminController::class, 'update']);
Route::post('adduser', [AdminController::class, 'store']);
// Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update');