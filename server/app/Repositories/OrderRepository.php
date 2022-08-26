<?php

namespace App\Repositories;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function byId(int $id): Order
    {
        return Order::find($id);
    }

    public function create(string $deliveryAddress, int $userId): Order
    {
        $order = new Order();
        $order->delivery_address = $deliveryAddress;
        $order->status = 'new';
        $order->user_id = $userId;

        $order->save();

        return $order;
    }

    public function update(Order $order, string $deliveryAddress, string $status, int $userId): Order
    {
        $order->delivery_address = $deliveryAddress;
        $order->status = $status;
        $order->user_id = $userId;

        $order->save();

        return $order;
    }

    public function initialQuery()
    {
        return Order::select(DB::raw('DISTINCT(o.id)'))
            ->from('orders as o')
            ->leftJoin('order_product as op', 'o.id', '=', 'op.order_id')
            ->leftJoin('products as p', 'p.id', '=', 'op.product_id')
            ->join('users as u', 'u.id', '=', 'o.user_id');
    }

    public function getFiltered(array $filters = []): Collection
    {
        $query = $this->initialQuery();

        if (!empty($filters['name'])) {
            $query->where(DB::raw("concat(u.firstname, ' ', u.lastname)"), 'like', $filters['name'] . '%');
        }

        if (!empty($filters['productTitle'])) {
            $query->where('title', 'like', $filters['productTitle'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        $filteredOrdersIds = $query->get()->map(function(Order $order) {
            return $order->id;
        })->toArray();

        return Order::whereIn('id', $filteredOrdersIds)->get();
    }

    public function getByDate(?string $dateFrom, ?string $dateTo)
    {
        if($dateFrom) {
            $dateFrom = Carbon::make($dateFrom)->setTime(0, 0, 0);
        }

        if($dateTo) {
            $dateTo = Carbon::make($dateTo)->setTime(23, 59, 59);
        }

        return Order::whereBetween('created_at', [$dateFrom, $dateTo])->get();
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }
}
