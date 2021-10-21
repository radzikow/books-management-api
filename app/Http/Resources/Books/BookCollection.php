<?php

namespace App\Http\Resources\Books;

use App\Http\Resources\Utils\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookCollection extends ResourceCollection
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
            'books' => BookResource::collection($this->collection),
            'pagination' => new PaginationResource($this->resource),
        ];
    }
}
