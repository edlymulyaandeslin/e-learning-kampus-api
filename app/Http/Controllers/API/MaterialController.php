<?php

namespace App\Http\Controllers\API;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function upload(Request $request)
    {
        try {
            $validateData = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'file_path' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip',
            ]);

            $filename = 'document_' . time() . mt_rand(10, 99) . '.' . $request->file('file_path')->getClientOriginalExtension();
            $path = $request->file('file_path')->storeAs('materials', $filename, 'public');

            $validateData['file_path'] = $path;

            Material::create($validateData);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => $validateData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function download(string $id)
    {
        try {
            $material = Material::findOrFail($id);
            $filePath = storage_path('app/public/' . $material->file_path);

            if (!file_exists($filePath)) {
                return response()->json([
                    'message' => 'File not found'
                ], 404);
            }

            return response()->download($filePath);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Download failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
