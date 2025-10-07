<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\AuthenticateController;

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

// Authentication routes
Route::post('register', [AuthenticateController::class, 'register'])->name('register');
Route::post('login', [AuthenticateController::class, 'login'])->name('api.login');
Route::post('logout', [AuthenticateController::class, 'logout'])->name('logout');

// Courses routes
Route::apiResource('courses', CourseController::class);
Route::post('courses/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');