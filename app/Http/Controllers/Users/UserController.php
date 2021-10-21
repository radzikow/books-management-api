<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\GetBooksRequest;
use App\Http\Requests\Books\GetOpinionsRequest;
use App\Http\Resources\Books\BookCollection;
use App\Http\Resources\Books\BookResource;
use App\Http\Resources\Books\OpinionCollection;
use App\Services\Books\BookService;
use App\Services\Books\OpinionService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private BookService $bookService;
    private OpinionService $opinionService;

    /**
     * UserController class constructor.
     */
    public function __construct(BookService $bookService, OpinionService $opinionService)
    {
        $this->bookService = $bookService;
        $this->opinionService = $opinionService;
    }

    /**
     * Get all the user books.
     *
     * @param GetBooksRequest $request
     *
     * @return JsonResponse
     */
    public function userBooks(GetBooksRequest $request): JsonResponse
    {
        $userBooks = $this->bookService->getUserBooks($request);

        if ($userBooks) {
            return $this->responseSuccess(new BookCollection($userBooks));
        }

        return $this->responseNotFoundError([
            'message' => 'Error occurred while getting the user books.'
        ]);
    }

    /**
     * Get a user book by id.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function userBook(int $id): JsonResponse
    {
        $userBook = $this->bookService->getUserBookById($id);

        if ($userBook) {
            return $this->responseSuccess(new BookResource($userBook));
        }

        return $this->responseNotFoundError([
            'message' => 'Book not found.'
        ]);
    }

    /**
     * Get user book opinions.
     *
     * @param GetOpinionsRequest $request
     *
     * @return JsonResponse
     */
    public function userBooksOpinions(GetOpinionsRequest $request): JsonResponse
    {
        $userBookOpinions = $this->opinionService->getAuthUserBooksOpinions($request);

        if ($userBookOpinions) {
            return $this->responseSuccess(new OpinionCollection($userBookOpinions));
        }

        return $this->responseNotFoundError([
            'message' => 'Opinions not found.',
        ]);
    }
}
