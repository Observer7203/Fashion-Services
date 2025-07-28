<?php

// app/Http/Controllers/Admin/MediaController.php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends \App\Http\Controllers\Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:25600', // 25MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Структура папки: products/2024/07/
            $folder = 'products/' . date('Y/m');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Сохраняем в storage/app/public/products/2024/07/
            $path = $file->storeAs($folder, $filename, 'public');

            // Storage::url вернёт /storage/products/2024/07/uuid.ext
            $url = Storage::url($path);

            return response()->json(['url' => $url]);
        }
        return response()->json(['error' => 'Нет файла'], 400);
    }

    public function delete(Request $request)
{
    \Log::info('DELETE REQUEST', ['input' => $request->all()]);

    $url = $request->input('url');
    if (!$url || !str_starts_with($url, '/storage/')) {
        return response()->json(['error' => 'Invalid URL'], 400);
    }

    $relativePath = str_replace('/storage/', '', $url);
    $storagePath = storage_path('app/public/' . $relativePath);

    if (file_exists($storagePath)) {
        unlink($storagePath);
        return response()->json(['success' => true]);
    }

    return response()->json(['error' => 'File not found'], 404);
}   

}

