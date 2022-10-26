<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model {
	/*protected $fillable = [
		'order_code', 'project_name', 'customer_name', 'phone', 'request_date', 'item_list', 'site_status', 'warehouse_status', 'work_site_id', 'eta_date', 'dispatch_date', 'receive_date', 'status',
	];*/

	protected $guarded = [];

	public function getItemListAttribute($value) {
		return json_decode($value);
	}

	public function product() {
		return $this->belongsTo('App\Product');
	}
	public function material_issue(){
    	return $this->belongsTo('App\MaterialIssue');
    }
}
