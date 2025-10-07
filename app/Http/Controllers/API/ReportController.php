<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\CourseUser;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function courses()
    {
        try {
            $courses = Course::withCount('courseUsers as total_students')->get();
            $totalCourse = Course::count();

            return response()->json([
                'success' => true,
                'message' => 'Course report generated successfully',
                'total_courses' => $totalCourse,
                'data' => $courses
            ], 200);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to generate course report',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function assignments()
    {
        try {
            $assignments = Assignment::withCount('submissions as total_submissions')->get();
            $totalAssignments = Assignment::count();

            return response()->json([
                'success' => true,
                'message' => 'Assignments report generated successfully',
                'total_assignments' => $totalAssignments,
                'data' => $assignments
            ], 200);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to generate course report',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function students(string $id)
    {
        try {
            $student = User::findOrFail($id);

            $totalCoursesEnrolled = CourseUser::where('student_id', $id)->count();
            $totalSubmissions = Submission::where('student_id', $id)->count();
            $avgScore = Submission::where('student_id', $id)->sum('score');
            $totalSubmissionsWithScore = Submission::where('student_id', $id)->whereNotNull('score')->count();

            return response()->json([
                'success' => true,
                'message' => 'Student report generated successfully',
                'data' =>  [
                    'student' => $student,
                    'total_courses_enrolled' => $totalCoursesEnrolled,
                    'total_submissions' => $totalSubmissions,
                    'average_score' => round($avgScore / $totalSubmissionsWithScore, 2),
                ]

            ], 200);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to generate student report',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }
}
