<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Services\ImageService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function index(Request $request)
    {
        $galleries = Gallery::where('page_key', 'gallery')->first();
        if($request->route()->named('admin.gallery.index'))
        {
            return view('admin.galleries.index', ['gallery' => $galleries]);
        }
        return view('user.galleries.index', ['gallery' => $galleries]);
    }



    public function storeGallery(Request $request, $model)
    {
        $model = $this->getModel($model, $request->id);
        return ImageService::storeOrUpdateGallery($request, $model, 'gallery');
    }

    public function uploadGallery(Request $request, $model, $id)
    {
        $model = $this->getModel($model, $id);
        return ImageService::storeOrUpdateGallery($request, $model, $request->attribute);
    }

    public function fetchGallery($model, $id)
    {
        $model = $this->getModel($model, $id);
        return ImageService::fetchDropzoneImages($model, 'gallery');
    }

    public function deleteGallery(Request $request, $model, $id)
    {
        $model = $this->getModel($model, $id);
        return ImageService::deleteDropzoneImages($model, $request, $request->attribute);
    }

    public function updateMetadata(Request $request, $model, $id)
    {
        $model = $this->getModel($model, $id);
        $fileName = $request->input('file_name');
        $attribute = $request->input('attribute');

        // Get the current gallery
        $gallery = $model->$attribute;

        if (is_array($gallery)) {
            // Update the metadata for the specified file
            foreach ($gallery as $key => $imageData) {
                $imagePath = is_string($imageData) ? $imageData : ($imageData['path'] ?? null);
                $imageName = basename($imagePath);

                if ($imageName === $fileName) {
                    // Convert string path to array with metadata if needed
                    if (is_string($imageData)) {
                        $gallery[$key] = [
                            'path' => $imageData,
                            'created_at' => now()->toDateTimeString()
                        ];
                    }

                    // Get all request inputs except these specific ones
                    $excludedKeys = ['_token', 'file_name', 'attribute'];

                    // Update all metadata fields dynamically
                    foreach ($request->all() as $metadataKey => $metadataValue) {
                        if (!in_array($metadataKey, $excludedKeys)) {
                            $gallery[$key][$metadataKey] = $metadataValue;
                        }
                    }

                    break;
                }
            }

            // Update the model
            $model->update([$attribute => $gallery]);

            return response()->json(['success' => 'Metadata updated successfully']);
        }

        return response()->json(['error' => 'Failed to update metadata'], 400);
    }

    public function getModel($model, $id)
    {
        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            abort(404, 'Model not found');
        }

        return $modelClass::findOrFail($id);
    }
}
