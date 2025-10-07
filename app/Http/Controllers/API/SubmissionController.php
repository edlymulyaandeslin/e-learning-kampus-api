<?php

namespace App\Http\Controllers\API;

use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{


    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'assignment_id' => 'required|exists:assignments,id',
                'student_id' => 'required|exists:users,id',
                'file_path' => 'required|file|mimes:pdf,doc,docx,zip|max:2048',
            ]);

            $filename = 'sub_' . time() . mt_rand(10, 99) . '.' . $request->file('file_path')->getClientOriginalExtension();
            $filePath = $request->file('file_path')->storeAs('submissions', $filename, 'public');

            $validateData['file_path'] = $filePath;

            Submission::create($validateData);

            return response()->json([
                'success' => true,
                'message' => 'Submission stored successfully',
                'data' => $validateData
            ], 201);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => 'Failed to store submission',
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function grade(string $id)
    {
        try {
            $submission = Submission::findOrFail($id);

            $validateData = request()->validate([
                'score' => 'required|numeric|min:0|max:100',
            ]);

            $submission->update($validateData);

            return response()->json([
                'success' => true,
                'message' => 'Submission graded successfully',
                'data' => $validateData
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => 'Failed to grade submission',
                    'message' => $e->getMessage()
                ],
                500
            );
        }
    }
}