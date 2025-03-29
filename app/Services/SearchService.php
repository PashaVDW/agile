<?php

namespace App\Services;

class SearchService
{
    protected $models = [
        \App\Models\Event::class,
        \App\Models\Sponsor::class,
        \App\Models\Announcement::class,
    ];

    public function search($query, $request)
    {
        $searchTerm = strtolower($request);
        $models = $this->models;
        $query->where(function ($query) use ($searchTerm, $models) {
            foreach ($models as $model) {
                foreach ($model->getSearchable() as $field) {
                    $query->orWhereRaw('LOWER('.$field.') like ?', ['%'.$searchTerm.'%']);
                }
            }
        });
    }

    public function searchEvents($query, $request, $model)
    {
        $searchTerm = strtolower($request);
        $query->where(function ($query) use ($searchTerm, $model) {
            foreach ((new $model)->getSearchable() as $field) {
                $query->orWhereRaw('LOWER('.$field.') like ?', ['%'.$searchTerm.'%']);
            }
        });
    }
}
