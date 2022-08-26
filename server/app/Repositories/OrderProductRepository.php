<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderProduct;

class OrderProductRepository
{
    public function create(Order $order, int $productId, int $productQuantity): OrderProduct
    {
        $orderProduct = new OrderProduct();

        $orderProduct->order_id = $order->id;
        $orderProduct->product_id = $productId;
        $orderProduct->product_quantity = $productQuantity;
        $orderProduct->price = $order->totalPrice();

        $orderProduct->save();

        return $orderProduct;
    }

    public function update(Order $order, int $productId, int $productQuantity): OrderProduct
    {
        $orderProduct = new OrderProduct();

        $orderProduct->order_id = $order->id;
        $orderProduct->product_id = $productId;
        $orderProduct->product_quantity = $productQuantity;
        $orderProduct->price = $order->totalPrice();

        $orderProduct->save();

        return $orderProduct;
    }
}
