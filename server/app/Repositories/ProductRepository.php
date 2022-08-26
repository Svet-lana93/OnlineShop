<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function list(): Collection
    {
        return Product::all();
    }

    public function getFiltered(array $filters = []): Collection
    {
        $query = Product::query();

        if (!empty($filters['title'])) {
            $query->where('title', 'like', $filters['title'] . '%');
        }

        return $query->get();
    }

    public function byId(int $id): Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        $product = new Product();

        $product->title = $data['title'];
        $product->description = $data['description'];
        $product->price = $data['price'];

        $product->save();

        return $product;
    }

    public function update(Product $product, array $data): Product
    {
        if (isset($data['title'])) {
            $product->title = $data['title'];
        }
        if (isset($data['description'])) {
            $product->description = $data['description'];
        }
        if (isset($data['price'])) {
            $product->price = $data['price'];
        }

        $product->save();

        return $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
