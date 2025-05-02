<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

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

    public function getModel($model, $id)
    {
        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            abort(404, 'Model not found');
        }

        return $modelClass::findOrFail($id);
    }
}
