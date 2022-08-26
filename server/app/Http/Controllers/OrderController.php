<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public OrderRepository $orderRepository;
    public OrderProductRepository $orderProductRepository;

    public function __construct(OrderRepository $orderRepository, OrderProductRepository $orderProductRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
    }

    public function list(Request $request): Factory|View|Application
    {
        $orders = $this->orderRepository->getFiltered($request->query->all());

        return view('orders.list', ['orders' => $orders, 'filters' => $request->query->all()]);
    }

    public function create(): Factory|View|Application
    {
        return view('orders.create', ['users' => User::all(), 'products' => Product::all(),
            'orderProduct' => OrderProduct::all()]);
    }

    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate([
            'delivery_address' => ['required'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if (!$order = $this->orderRepository->create($request->delivery_address, $request->user_id)) {
            abort(404);
        }

        $request->validate([
            'product.*' => ['required', 'exists:products,id'],
            'product' => ['required', 'array'],
            'product_quantity' => ['required', 'array', 'min:1'],
        ]);

        foreach ($request->product as $key => $product) {
            $this->orderProductRepository->create($order, $product, $request->product_quantity[$key]);
        }

        return redirect(route('orders.list'));
    }

    public function edit(int $id): Factory|View|Application
    {
        if (!$order = $this->orderRepository->byId($id)) {
            abort(404);
        }

        return view('orders.update', ['products' => Product::all(), 'order' => $order]);
    }

    public function update(int $id, Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate([
            'delivery_address' => ['required'],
            'status' => ['required'],
        ]);

        if (!$order = $this->orderRepository->byId($id)) {
            abort(404);
        }

        $this->orderRepository->update($order, $request->delivery_address, $request->status, $order->user_id);

        $request->validate([
            'product.*' => ['required', 'exists:products,id'],
            'product' => ['required', 'array'],
            'product_quantity' => ['required', 'array', 'min:1'],
        ]);

        $this->delete($order->id);

        foreach ($request->product as $key => $product) {
            $this->orderProductRepository->update($order, $product, $request->product_quantity[$key]);
        }

        return redirect(route('orders.list'));
    }

    public function statistics(Request $request): Factory|View|Application
    {
        $dateFrom = $request->query('dateFrom');
        $dateTo = $request->query('dateTo');

        $orders = $this->orderRepository->getByDate($dateFrom, $dateTo);
        $amountOfOrders = $orders->count();

        $totalPrice = 0;
        foreach($orders as $order) {
            $totalPrice += $order->totalPrice();
        }

        return view('orders.statistics', ['amountOfOrders' => $amountOfOrders, 'totalPrice' => $totalPrice, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }

    public function delete(int $id): void
    {
        if (!$order = $this->orderRepository->byId($id)) {
            abort(404);
        }

        $this->orderRepository->delete($order);
    }
}
