<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController
{
    public ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list(): AnonymousResourceCollection
    {
        return ProductResource::collection($this->productRepository->list());
    }

    public function product(int $id): ProductResource
    {
        if (!$product = $this->productRepository->byId($id)) {
            abort(404);
        }

        return new ProductResource($product);
    }
}
