<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialRequestResource extends JsonResource
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

        return [
            "id" => $this->id,
            "request_code" => $this->request_code,
            "request_date" => $this->request_date,
            "status" => $this->status,
            "warehouse_status" => $this->warehouse_status,
            "site_status" => $this->site_status,
            "received_date" => $this->received_date,
            "remark" => $this->remark,
            "status" => $this->status,
            "created_at" => $this->created_at,
        ];
    }
}
