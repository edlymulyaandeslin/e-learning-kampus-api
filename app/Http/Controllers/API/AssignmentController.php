<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'deadline' => 'required|date',
            ]);

            Assignment::create($validateData);

            return response()->json([
                'success' => true,
                'message' => 'Assignment stored successfully',
                'data' => $validateData
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed stored assignment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}