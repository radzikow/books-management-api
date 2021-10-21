<?php

namespace App\Http\Resources\Books;

use App\Http\Resources\Utils\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OpinionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'opinions' => OpinionResource::collection($this->collection),
            'pagination' => new PaginationResource($this->resource),
        ];
    }
}
