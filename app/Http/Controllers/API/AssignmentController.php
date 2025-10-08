<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Assignment as MailAssignment;

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

            $assignment = Assignment::create($validateData);

            $users = User::where('role', User::ROLE_STUDENT)->whereHas('courseUsers', function ($query) use ($assignment) {
                $query->where('course_id', $assignment->course_id);
            })->get();

            foreach ($users as $user) {
                Mail::to($user)->send(new MailAssignment($assignment));

                sleep(10); // not best practice
            }

            return response()->json([
                'success' => true,
                'message' => 'Assignment stored successfully',
                'data' => $validateData,
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