<?php

namespace App\Filters\Books;

use App\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookFilters extends QueryFilters
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    /**
     * Filter books by title.
     *
     * @param $value
     *
     * @return Builder
     */
    public function title($value): Builder
    {
        return $this->builder->where('title', 'LIKE', "%${value}%");
    }

    /**
     * Filter books by description.
     *
     * @param $value
     *
     * @return Builder
     */
    public function description($value): Builder
    {
        return $this->builder->where('description', 'LIKE', "%${value}%");
    }
}
