<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(): JsonResponse
    {
        $files = File::all();
        return response()->json([
            'message' => 'Files retrieved successfully.',
            'data' => $files
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:10240',
            'description' => 'nullable|string|max:500'
        ]);

        $filePath = $request->file('file')->store('files', 'public');
        
        $file = File::create([
            'file_path' => $filePath,
            'file_name' => $request->file('file')->getClientOriginalName(),
            'description' => $validated['description'] ?? null
        ]);

        return response()->json([
            'message' => 'File uploaded successfully.',
            'data' => $file
        ], 201);
    }

    public function show(File $file): JsonResponse
    {
        return response()->json([
            'message' => 'File retrieved successfully.',
            'data' => $file
        ]);
    }

    public function update(Request $request, File $file): JsonResponse
    {
        $validated = $request->validate([
            'description' => 'sometimes|nullable|string|max:500'
        ]);

        $file->update($validated);
        return response()->json([
            'message' => 'File updated successfully.',
            'data' => $file
        ]);
    }

    public function destroy(File $file): JsonResponse
    {
        if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }
        
        $file->delete();
        return response()->json([
            'message' => 'File deleted successfully.'
        ]);
    }

    public function download(File $file)
    {
        if (!Storage::disk('public')->exists($file->file_path)) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }
}
