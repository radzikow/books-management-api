<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\GetOpinionsRequest;
use App\Http\Requests\Books\StoreOpinionRequest;
use App\Http\Resources\Books\OpinionCollection;
use App\Http\Resources\Books\OpinionResource;
use App\Services\Books\OpinionService;
use Illuminate\Http\JsonResponse;

class OpinionController extends Controller
{
    private OpinionService $opinionService;

    /**
     * OpinionController class constructor.
     */
    public function __construct(OpinionService $opinionService)
    {
        $this->opinionService = $opinionService;
    }

    /**
     * Get all the opinions.
     *
     * @return JsonResponse
     */
    public function index(GetOpinionsRequest $request): JsonResponse
    {
        $opinions = $this->opinionService->getAllOpinions($request);

        if ($opinions) {
            return $this->responseSuccess(new OpinionCollection($opinions));
        }

        return $this->responseUnprocessableEntityError([
            'message' => 'Error occurred while getting the opinions.',
        ]);
    }

    /**
     * Store a new opinion about a book.
     *
     * @param AddOpinionRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreOpinionRequest $request): JsonResponse
    {
        $opinion = $this->opinionService->addOpinion($request);

        if ($opinion) {
            return $this->responseSuccess([
                'opinion' => new OpinionResource($opinion),
                'message' => 'New opinion added successfully.',
            ]);
        }

        return $this->responseUnprocessableEntityError([
            'message' => 'Error occurred while adding a new opinion.',
        ]);
    }

    /**
     * Get a opinion by id.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $opinion = $this->opinionService->getOpinionById($id);

        if ($opinion) {
            return $this->responseSuccess(new OpinionResource($opinion));
        }

        return $this->responseNotFoundError([
            'message' => 'Opinion not found.',
        ]);
    }
}
