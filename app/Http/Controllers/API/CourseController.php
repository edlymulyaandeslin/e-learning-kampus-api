<?php

namespace App\Http\Controllers\API;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Courses',
            'data'    => $courses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'lecturer_id' => 'required|exists:users,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            Course::create($validateData);

            return response()->json([
                'success' => true,
                'message' => 'Course stored successfully',
                'data'    => $validateData
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store course',
                'error'   => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $course = Course::findOrFail($id);

            $rules = [
                'lecturer_id' => 'required|exists:users,id',
            ];

            if ($request->filled('name')) {
                $rules['name'] = 'string|max:255';
            }

            if ($request->filled('description')) {
                $rules['description'] = 'required';
            }

            $validateData = $request->validate($rules);

            $course->update($validateData);

            return response()->json([
                'success' => true,
                'message' => 'Course updated successfully',
                'data'    => $course,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to updated course',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json([
                'success' => true,
                'message' => 'Course deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete course',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function enroll(string $id)
    {
        try {
            $course = Course::findOrFail($id);
            $student = auth('api')->user();

            // Check if already enrolled
            if ($course->courseUsers()->where('student_id', $student->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student already enrolled in this course',
                ], 400);
            }

            $course->courseUsers()->create([
                'student_id' => $student->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Student enrolled in course successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to enroll course',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}