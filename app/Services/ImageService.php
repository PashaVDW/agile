<?php

namespace App\Services;

use App\Jobs\ProcessImageUpload;
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

    public static function deleteImage($class, $model, $type)
    {
        if ($model->$type) {
            $otherModels = $class::where($type, $model->$type)->where('id', '!=', $model->id)->count();
            if ($otherModels === 0) {
                Storage::disk('public')->delete($model->$type);
            }
        }
    }

    public static function deleteImages($class, $model)
    {
        $gallery = $model->gallery;
        $otherModels = $class::where('id', '!=', $model->id)->get();

        if (is_array($gallery)) {
            foreach ($gallery as $image) {
                $isUsed = false;
                foreach ($otherModels as $otherModel) {
                    $otherGallery = $otherModel->gallery;
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

    public static function deleteStoredImages($class, $model, $type = null)
    {
        if ($type && $model->$type && $type !== 'gallery') {
            ImageService::deleteImage($class, $model, $type);
        }
        if ($model->gallery) {
            ImageService::deleteImages($class, $model);
        }
    }

    public static function storeOrUpdateGallery($request, $model, $type)
    {
        try {
            if ($request->hasFile($type)) {
                $files = is_array($request->file($type)) ? $request->file($type) : [$request->file($type)];
                return ImageService::processGalleryImages($files, $model, $type);
            }
            return response()->json(['success' => 'Images uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    private static function processGalleryImages($files, $model, $type, $maxFiles = 0) // 0 means no limit
    {
        [$galleryPaths, $errors] = ImageService::save($files, strtolower(class_basename($model)), $type);
        if (!empty($errors)) {
            return response()->json(['error' => $errors], 400);
        }

        $error = ImageService::mergeImages($galleryPaths, $model, $type, $maxFiles);

        if ($error) {
            return response()->json(['error' => $error], 400);
        }
        return response()->json(['success' => 'Images uploaded successfully']);
    }

    private static function save($files, $class, $type)
    {
        $galleryPaths = [];
        $errors = [];
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            $path = 'images/'.$class.'/'.$type;
            $relativePath = $path.'/' . $filename;

            if (Storage::disk('public')->exists($relativePath) || in_array($relativePath, $galleryPaths)) {
                $errors[] = "Het bestand $filename bestaat al.";
            } else {
                $filePath = $file->storeAs($path, $file->getClientOriginalName(), 'public');
                ProcessImageUpload::dispatch($filePath, $file->getClientOriginalName(), $path);
                $galleryPaths[] = $relativePath;
            }
        }
        return [$galleryPaths, $errors];
    }

    private static function mergeImages($galleryPaths, $model, $type, $maxFiles)
    {
        $error = null;
        if($model) {
            $existingImages = $model->$type ?? [];
            $mergedImages = array_merge($existingImages, $galleryPaths);

            if ($maxFiles > 0 && count($mergedImages) > $maxFiles) {
                $error = "De gallerij kan niet meer dan " . $maxFiles . " bestanden bevatten.";
                $mergedImages = array_slice($mergedImages, 0, $maxFiles);
            }
            $model->update([$type => empty($mergedImages) ? null : $mergedImages]);
        }
        return $error;
    }

    public static function fetchDropzoneImages($model, $type)
    {
        try {
            $files = [];
            if ($model) {
                $imageArray = is_array($model->$type) ? $model->$type : json_decode($model->$type, true);
                if (is_array($imageArray)) {
                    foreach ($imageArray as $imagePath) {
                        $filePath = public_path($imagePath);
                        $files[] = [
                            'name' => basename($imagePath),
                            'size' => file_exists($filePath) ? filesize($filePath) : 0,
                            'path' => asset(Storage::url($imagePath)),
                        ];
                    }
                }
            }
            return response()->json($files);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public static function deleteDropzoneImages($model, $request, $type)
    {
        try {
            ImageService::processGalleryDelete($model, $request, $type);
            return response()->json(['success' => 'Images deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    private static function processGalleryDelete($model, $request, $type)
    {
        $fileNames = $request->input('file_names', []);
        if ($model && is_array($model->$type)) {
            $normalizedFileNames = array_map('strtolower', array_map('trim', $fileNames));
            $updatedImages = array_filter($model->$type, function ($image) use ($type, $normalizedFileNames, $model) {
                $imageName = strtolower(basename($image));
                if (in_array($imageName, $normalizedFileNames)) {
                    $isUsedInOtherModels = get_class($model)::where($type, 'like', '%' . $imageName . '%')
                        ->where('id', '!=', $model->id)
                        ->exists();
                    if (!$isUsedInOtherModels) {
                        Storage::disk('public')->delete($image);
                    }
                    return false;
                }
                return true;
            });
            $model->update([$type => array_values($updatedImages)]);
        }
    }
}
