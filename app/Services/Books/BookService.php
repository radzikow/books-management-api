<?php

namespace App\Services\Books;

use App\Filters\Books\BookFilters;
use App\Http\Requests\Books\GetBooksRequest;
use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Models\Book;
use App\Services\Users\UserService;
use App\Services\Utils\ConstService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BookService
{
    private UserService $userService;
    private OpinionService $opinionService;

    /**
     * BookService class constructor.
     */
    public function __construct(UserService $userService, OpinionService $opinionService)
    {
        $this->userService = $userService;
        $this->opinionService = $opinionService;
    }

    /**
     * Get a list of all the books with their authors.
     *
     * @param GetBooksRequest $request
     * @param BookFilters $bookFilters
     *
     * @return Collection
     */
    public function getBooks(GetBooksRequest $request, BookFilters $bookFilters): LengthAwarePaginator
    {
        $perPage = (int) $request
            ->get('per_page', ConstService::DEFAULT_PER_PAGE);

        return Book::filter($bookFilters)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get a list of all the books by user id.
     *
     * @param int $userId
     *
     * @return LengthAwarePaginator|null
     */
    public function getUserBooks(GetBooksRequest $request, int $userId = null): ?LengthAwarePaginator
    {
        $perPage = (int) $request
            ->get('per_page', ConstService::DEFAULT_PER_PAGE);

        return Book::where('user_id', $this->userService->getUserByIdOrAuthUser($userId)->id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get a book by id with its author.
     *
     * @param int $id
     *
     * @return Collection|null
     */
    public function getBookDetailsById(int $id): ?Collection
    {
        $book = Book::find($id);

        if (!$book) {
            return null;
        }

        return collect([
            'book' => $book,
            'author' => $book->user()->first(),
            'opinions' => $this->opinionService->getOpinionsByBookId($id),
        ]);
    }

    /**
     * Get a book by id with its author.
     *
     * @param int $bookId
     * @param int|null $userId
     *
     * @return Book|null
     */
    public function getUserBookById(int $bookId, int $userId = null): ?Book
    {
        return Book::where('user_id', $this->userService->getUserByIdOrAuthUser($userId)->id)
            ->find($bookId);
    }

    /**
     * Get a book by id with its author.
     *
     * @param StoreBookRequest $request
     *
     * @return Book|null
     */
    public function addBook(StoreBookRequest $request): ?Book
    {
        return Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'ISBN' => $request->ISBN,
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Update a book by id.
     *
     * @param int $id
     * @param UpdateBookRequest $request
     *
     * @return Book|null
     */
    public function updateBook(int $id, UpdateBookRequest $request): ?Book
    {
        $book = Book::find($id);

        if (!$book || $book->user_id !== auth()->id()) {
            return null;
        }

        if ($request->has('title')) {
            $book->title = $request->input('title');
        }

        if ($request->has('description')) {
            $book->description = $request->input('description');
        }

        $book->save();

        return $book;
    }

    /**
     * Delete a book by id.
     *
     * @param int $id
     *
     * @return bool
     */
    public function deleteBook(int $id): bool
    {
        $book = Book::doesntHave('opinions')
            ->find($id);

        if (!$book || $book->user_id !== auth()->id()) {
            return false;
        }

        $book->delete();

        return true;
    }
}
