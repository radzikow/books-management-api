<?php

namespace App\Http\Controllers\Books;

use App\Filters\Books\BookFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\Books\GetBooksRequest;
use App\Http\Requests\Books\StoreBookRequest;
use App\Http\Requests\Books\UpdateBookRequest;
use App\Http\Resources\Books\BookCollection;
use App\Http\Resources\Books\BookResource;
use App\Services\Books\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    private BookService $bookService;

    /**
     * BookController class constructor.
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Get all the books.
     *
     * @param GetBooksRequest $request
     * @param BookFilters $bookFilters
     *
     * @return JsonResponse
     */
    public function index(GetBooksRequest $request, BookFilters $bookFilters): JsonResponse
    {
        $books = $this->bookService->getBooks($request, $bookFilters);

        if ($books) {
            return $this->responseSuccess(new BookCollection($books));
        }

        return $this->responseUnprocessableEntityError([
            'message' => 'Error occurred while getting the books.',
        ]);
    }

    /**
     * Store a new book.
     *
     * @param StoreBookRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $addedBook = $this->bookService->addBook($request);

        if ($addedBook) {
            return $this->responseSuccess(new BookResource($addedBook));
        }

        return $this->responseNotFoundError([
            'message' => 'Error occurred while adding a book.',
        ]);
    }

    /**
     * Get a book by id.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $book = $this->bookService->getBookDetailsById($id);

        if ($book) {
            return $this->responseSuccess(new BookResource($book));
        }

        return $this->responseNotFoundError([
            'message' => 'Book not found.',
        ]);
    }

    /**
     * Update a book by id.
     *
     * @param int $id
     * @param UpdateBookRequest $request
     *
     * @return JsonResponse
     */
    public function update(int $id, UpdateBookRequest $request): JsonResponse
    {
        $updatedBook = $this->bookService->updateBook($id, $request);

        if ($updatedBook) {
            return $this->responseSuccess(new BookResource($updatedBook));
        }

        return $this->responseUnprocessableEntityError([
            'message' => 'Error occurred while updating a book.',
        ]);
    }

    /**
     * Delete book by id.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDeleted = $this->bookService->deleteBook($id);

        if ($isDeleted) {
            return $this->responseSuccess([
                'message' => 'Book deleted successfully.',
            ]);
        }

        return $this->responseUnprocessableEntityError([
            'message' => 'Book could not be deleted.',
        ]);
    }
}
