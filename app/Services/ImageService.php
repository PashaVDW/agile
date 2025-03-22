<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function StoreImage($request, $image, $path = "")
    {
        if ($request->hasFile($image)) {
            $file = $request->file($image);
            $filePath = 'image/' . $file->getClientOriginalName();
            if (!Storage::disk('public')->exists($filePath)) {
                $filePath = $file->storeAs('images'.$path, $file->getClientOriginalName(), 'public');
            }
            return $filePath;
        }
        return null;
    }

    public static function deleteImage($class, $model)
    {
        if ($model->banner) {
            $otherEvents = $class::where('banner', $model->banner)->where('id', '!=', $model->id)->count();
            if ($otherEvents === 0) {
                Storage::disk('public')->delete($model->banner);
            }
        }

        if ($model->image) {
            $otherEvents = $class::where('image', $model->image)->where('id', '!=', $model->id)->count();
            if ($otherEvents === 0) {
                Storage::disk('public')->delete($model->image);
            }
        }

        if ($model->logo) {
            $otherEvents = $class::where('logo', $model->logo)->where('id', '!=', $model->id)->count();
            if ($otherEvents === 0) {
                Storage::disk('public')->delete($model->logo);
            }
        }
    }

    public static function deleteImages($class, $model)
    {
        $gallery = json_decode($model->gallery);
        $otherModels = $class::where('id', '!=', $model->id)->get();

        if (is_array($gallery)) {
            foreach ($gallery as $image) {
                $isUsed = false;
                foreach ($otherModels as $otherModel) {
                    $otherGallery = json_decode($otherModel->gallery);
                    if (is_array($otherGallery) && in_array($image, $otherGallery)) {
                        $isUsed = true;
                        break;
                    }
                }
                if (!$isUsed) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
    }
}
