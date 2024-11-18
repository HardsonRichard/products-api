<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductQueryParamsRequest;
use App\Http\Requests\ProductReqeust;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductQueryParamsRequest $request): AnonymousResourceCollection
    {
        $queryParams = $request->validated();

        $query = Product::query();

        $products = $query->filter(
            $queryParams,
            ['name', 'description'],
        )
            ->paginate(
                $queryParams['per_page'] ?? 15,
                ['*'],
                'page',
                $queryParams['page'] ?? 1,
            );

        return ProductResource::collection($products);
    }

    /**
     *  Store a newly created product in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(ProductRequest $request): JsonResource
    {
        $product = Product::create($request->validated());

        return new ProductResource($product);
    }

    /**
     * Display a specified product from storage
     *
     * @param Product $product
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Product $product): JsonResource
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified product in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(ProductRequest $request, Product $product): JsonResource
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }
}