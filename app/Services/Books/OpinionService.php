<?php

namespace App\Services\Books;

use App\Http\Requests\Books\GetOpinionsRequest;
use App\Http\Requests\Books\StoreOpinionRequest;
use App\Models\Opinion;
use App\Services\Utils\ConstService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OpinionService
{
    /**
     * Get a list of all the books opinions.
     *
     * @param GetOpinionsRequest $request
     *
     * @return LengthAwarePaginator
     */
    public function getAllOpinions(GetOpinionsRequest $request): LengthAwarePaginator
    {
        $perPage = (int) $request
            ->get('per_page', ConstService::DEFAULT_PER_PAGE);

        return Opinion::orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get a list of all the books opinions by book id.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function getOpinionsByBookId(int $id): Collection
    {
        return Opinion::where('book_id', $id)
            ->get();
    }

    /**
     * Get a book opinion by id.
     *
     * @param int $id
     *
     * @return Opinion|null
     */
    public function getOpinionById(int $id): ?Opinion
    {
        $opinion = Opinion::find($id);

        if (!$opinion) {
            return null;
        }

        return $opinion;
    }

    /**
     * Get authenticated user books opinions.
     *
     * @param GetOpinionsRequest $request
     *
     * @return LengthAwarePaginator
     */
    public function getAuthUserBooksOpinions(GetOpinionsRequest $request): LengthAwarePaginator
    {
        $perPage = (int) $request
            ->get('per_page', ConstService::DEFAULT_PER_PAGE);

        return Opinion::whereRelation('book', 'user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Add a new opinion about a book.
     *
     * @param StoreOpinionRequest $request
     *
     * @return Opinion
     */
    public function addOpinion(StoreOpinionRequest $request): Opinion
    {
        return Opinion::create([
            'rating' => $request->rating,
            'content' => $request->content,
            'author' => $request->author,
            'email' => $request->email,
            'book_id' => $request->book_id,
        ]);
    }
}
