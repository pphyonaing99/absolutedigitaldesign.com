<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
        $product_info = $this->product;

        return [
            'product_name' => $product_info->name,
            'purchase_order_id' => $this->purchase_order_id,
            'stock_qty' => $this->stock_qty,
        ];
    }
}
