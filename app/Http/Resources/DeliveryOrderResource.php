<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOrderResource extends JsonResource
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
        $project_info = $this->project;
        $delivery_date = date('d-m-Y', strtotime($request->delivery_date));
        return [
            'id' => $this->id,
            'purchase_order_id' => $this->purchase_order_id,
            'delivery_date' => $delivery_date,
            // 'item_list' => $this->item_list,
            'project_id' => $this->project_id,
            'project_name' => $project_info->project_name,
            'phase_id' => $this->phase_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
