<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingQueryParamsRequest;
use App\Http\Requests\UserRatingRequest;
use App\Http\Resources\UserRatingResource;
use App\Models\UserRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingController extends Controller
{
    /**
     * Display a listing of the user-ratings.
     *
     * @param RatingQueryParamsRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(RatingQueryParamsRequest $request): AnonymousResourceCollection
    {
        $queryParams = $request->validated();

        $query = UserRating::query();

        $user_ratings = $query->filter(
            $queryParams,
            ['rating'],
        )
            ->paginate(
                $queryParams['per_page'] ?? 15,
                ['*'],
                'page',
                $queryParams['page'] ?? 1,
            );

        return UserRatingResource::collection($user_ratings);
    }

    /**
     * Store a new created user-rating in storage
     *
     * @param UserRatingRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(UserRatingRequest $request): JsonResource
    {
        $user_rating = UserRating::create($request->validated());

        return new UserRatingResource($user_rating);
    }

    /**
     * Display the specified user-rating.
     *
     * @param UserRating $userRating
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(UserRating $userRating): JsonResource
    {
        return new UserRatingResource($userRating);
    }

    /**
     * Update the specified user-rating in storage.
     *
     * @param UserRatingRequest $request
     * @param UserRating $userRating
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UserRatingRequest $request, UserRating $userRating): JsonResource
    {
        $userRating->update($request->validated());

        return new UserRatingResource($userRating);
    }

    /**
     * Remove the specified user_rating from storage.
     *
     * @param UserRating $userRating
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserRating $userRating): JsonResponse
    {
        $userRating->delete();

        return response()->json(null, 204);
    }
}