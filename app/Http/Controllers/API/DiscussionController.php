<?php

namespace App\Http\Controllers\API;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscussionController extends Controller
{

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'user_id' => 'required|exists:users,id',
                'content' => 'required|string',
            ]);

            Discussion::create($validateData);

            return response()->json([
                'success' => true,
                'message' => 'Discussion created successfully',
                'data' => $validateData
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create discussion',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function reply(Request $request, string $id)
    {
        try {
            $discussion = Discussion::findOrFail($id);

            $validateData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'content' => 'required|string',
            ]);

            $discussion->replies()->create($validateData);

            return response()->json([
                'success' => true,
                'message' => 'Replies created successfully',
                'data' => $validateData
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to create Replies',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
