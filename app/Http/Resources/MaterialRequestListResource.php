<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialRequestListResource extends JsonResource
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

        $material_request_info = $this->product;
        
        return [
            'id' => $this->id,
            'material_request_id' => $this->material_request_id,
            'product_id' => $this->product_id,
            'product_name' => $material_request_info->name,
            'request_qty' => $this->request_qty,
            'created_at' => $this->created_at,
        ];
    }
}
