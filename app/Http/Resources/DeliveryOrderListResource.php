<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $delivery_order_info = $this->product;
        
        return [
            'id' => $this->id,
            'delivery_order_id' => $this->delivery_order_id,
            'product_name' => $delivery_order_info->name,
            'stock_qty' => $this->stock_qty,
            'created_at' => $this->created_at,
        ];
    }
}
