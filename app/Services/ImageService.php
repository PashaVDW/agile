<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function StoreImage($request, $image)
    {
        if ($request->hasFile($image)) {
            $file = $request->file($image);
            $filePath = 'images/' . $file->getClientOriginalName();
            if (!Storage::disk('public')->exists($filePath)) {
                $filePath = $file->storeAs('images', $file->getClientOriginalName(), 'public');
            }
            return $filePath;
        }
        return null;
    }
}
