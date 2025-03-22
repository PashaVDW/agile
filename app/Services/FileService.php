<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function StoreFile($request, $file, $path = "")
    {
        if ($request->hasFile($file)) {
            $file = $request->file($file);
            $filePath = 'file/' . $file->getClientOriginalName();
            if (!Storage::disk('public')->exists($filePath)) {
                $filePath = $file->storeAs('files'.$path, $file->getClientOriginalName(), 'public');
            }
            return $filePath;
        }
        return null;
    }
}
