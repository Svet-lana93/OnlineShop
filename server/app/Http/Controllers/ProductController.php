<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list(Request $request): Factory|View|Application
    {
        $products = $this->productRepository->getFiltered($request->query->all());

        return view('products.list', ['products' => $products, 'filters' => $request->query->all()]);
    }

    public function edit(int $id): Factory|View|Application
    {
        if (!$product = $this->productRepository->byId($id)) {
            abort(404);
        }

        return view('products.update', ['product' => $product]);
    }

    public function update(int $id, Request $request): Redirector|Application|RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'min:1','max:255', 'numeric'],
        ]);
        if (!$product = $this->productRepository->byId($id)) {
            abort(404);
        }

        $this->productRepository->update($product, $data);

        return redirect(route('products.list'));
    }

    public function create(): Factory|View|Application
    {
        return view('products.create');
    }

    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'min:1','max:255', 'numeric'],
        ]);

        $this->productRepository->create($data);

        return redirect(route('products.list'));
    }

    public function delete(int $id): Redirector|Application|RedirectResponse
    {
        if (!$product = $this->productRepository->byId($id)) {
            abort(404);
        }
        $this->productRepository->delete($product);

        return redirect(route('products.list'));
    }
}
