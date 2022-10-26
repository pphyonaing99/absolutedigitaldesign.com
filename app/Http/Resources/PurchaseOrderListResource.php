<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductListResource;

class PurchaseOrderListResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request) {
		// return parent::toArray($request);

		$request_date = date('d-m-Y', strtotime($request->request_date));
		return [
			'id' => $this->id,
			'order_code' => $this->order_code,
			'request_date' => $request_date,
			// 'item_list' => $this->item_list,
			'site_status' => $this->site_status,
			'work_site_id' => $this->work_site_id,
			'created_at' => $this->created_at,
		];
	}
}
