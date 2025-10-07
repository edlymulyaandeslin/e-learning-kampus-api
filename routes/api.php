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
Route::post('logout', [AuthenticateController::class, 'logout'])->name('logout');

// Courses routes
Route::apiResource('courses', CourseController::class);
Route::post('courses/{id}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

// Material routes
Route::post('materials', [MaterialController::class, 'upload'])->name('materials.upload');
Route::get('materials/{id}/download', [MaterialController::class, 'download'])->name('materials.download');

// Assignment and submission routes
Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
Route::post('submissions', [SubmissionController::class, 'store'])->name('submissions.store');
Route::post('submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');

// Forum discussion routes
Route::post('discussions', [DiscussionController::class, 'store'])->name('discussions.store');
Route::post('discussions/{id}/replies', [DiscussionController::class, 'reply'])->name('discussions.reply');

// Report routes
Route::get('reports/courses', [ReportController::class, 'courses'])->name('report.courses');
Route::get('reports/assignments', [ReportController::class, 'assignments'])->name('report.assignments');
Route::get('reports/students/{id}', [ReportController::class, 'students'])->name('report.students');
