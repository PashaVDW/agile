<?php

namespace App\Services;

class SearchService
{
    protected $models = [
        \App\Models\Event::class,
        \App\Models\Sponsor::class,
    ];

    public function multiSearch($query, $request)
    {
        $searchTerm = strtolower($request);
        $models = $this->models;
        $query->where(function ($query) use ($searchTerm, $models) {
            foreach ($models as $model) {
                foreach ($model->getSearchable() as $field) {
                    $query->orWhereRaw('LOWER(' . $field . ') like ?', ['%' . $searchTerm . '%']);
                }
            }
        });
    }


    public function singleSearch($query, $request, $model){
        $searchTerm = strtolower($request);
        $query->where(function ($query) use ($searchTerm, $model) {
            foreach ((new $model)->getSearchable() as $field) {
                $query->orWhereRaw('LOWER(' . $field . ') like ?', ['%' . $searchTerm . '%']);
            }
        });
    }

    public function searchByDate($query, mixed $search, string $class)
    {
        if (preg_match('/\b\d{2}-\d{2}-\d{4}\b/', $search, $fullDate) > 0) {
            $this->singleSearch($query, date('Y-m-d', strtotime($fullDate[0])), $class);
        }
        else if(preg_match('/\b\d{2}-\d{4}\b/', $search, $monthYear) > 0) {
            $formattedDate = '01-' . $monthYear[0];
            $this->singleSearch($query, date('Y-m', strtotime($formattedDate)), $class);
        }
        else if(preg_match('/\b\d{2}-\d{2}\b/', $search, $monthDay) > 0) {
            $formattedDate = $monthDay[0] . '-' . date('Y');
            $this->singleSearch($query, date('m-d', strtotime($formattedDate)), $class);
        }
        else {
            $this->singleSearch($query, $search, $class);
        }
    }
}
