<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Tests extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $filtered = [];
        $this->collection->each(function ($test) use (&$filtered) {
            $filtered[] = array_only($test->toArray(), ['id', 'name']);
        });

        return [
            'data' => $filtered
        ];
    }
}
