<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'delivery_address' => $this->delivery_address,
            'status' => $this->status,
            'created_at' => date("Y-m-d H:i:s", strtotime($this->created_at)),
            'user' => new UserResource($this->user),
            'order_product' => OrderProductResource::collection($this->orderProduct)
        ];
    }
}
