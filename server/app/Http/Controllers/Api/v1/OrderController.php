<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\OrderResource;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController
{
    public OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function order(int $id): OrderResource
    {
        if (!$order = $this->orderRepository->byId($id)) {
            abort(404);
        }
        return new OrderResource($order);
    }

    public function userOrders(int $userId): AnonymousResourceCollection
    {
        $userRepository = new UserRepository();
        $user = $userRepository->byId($userId);

        return OrderResource::collection($user->orders);
    }

    public function create(Request $request, OrderProductRepository $orderProductRepository): OrderResource
    {
        $request->validate([
            'delivery_address' => ['required'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if (!$order = $this->orderRepository->create($request->delivery_address, $request->user_id)) {
            abort(404);
        }

        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_quantity' => ['required'],
        ]);

        $orderProductRepository->create($order, $request->product_id, $request->product_quantity);

        return new OrderResource($order);
    }
}
