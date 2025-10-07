<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\MaterialController;
use App\Http\Controllers\API\AssignmentController;
use App\Http\Controllers\API\DiscussionController;
use App\Http\Controllers\API\SubmissionController;
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

// Route Group with auth:sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthenticateController::class, 'logout'])->name('logout');

    // Material routes
    Route::get('materials/{id}/download', [MaterialController::class, 'download'])->name('materials.download');

    // Forum discussion routes
    Route::post('discussions', [DiscussionController::class, 'store'])->name('discussions.store');
    Route::post('discussions/{id}/replies', [DiscussionController::class, 'reply'])->name('discussions.reply');

    // Report routes
    Route::get('reports/courses', [ReportController::class, 'courses'])->name('report.courses');
    Route::get('reports/assignments', [ReportController::class, 'assignments'])->name('report.assignments');
    Route::get('reports/students/{id}', [ReportController::class, 'students'])->name('report.students');
});

// Route group with isLecturer middleware
Route::middleware('isLecturer')->group(function () {
    // Courses routes
    Route::apiResource('courses', CourseController::class);

    // Upload course materials
    Route::post('materials', [MaterialController::class, 'upload'])->name('materials.upload');

    // Assignment and grading routes
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::post('submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
});

// Route group with isStudent middleware
Route::middleware('isStudent')->group(function () {
    // Student enroll courses
    Route::post('courses/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

    // Submission routes
    Route::post('submissions', [SubmissionController::class, 'store'])->name('submissions.store');
});
