<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model {
	protected $fillable = [
		'request_code', 'item_list','user_id', 'request_date', 'warehouse_status', 'site_status', 'eta_date', 'dispatch_date', 'receive_date', 'status','remark',
	];

	public function getItemListAttribute($value) {
		return json_decode($value);
	}	
	public function product(){
		return $this->belongsTo('App\Product');
	}	
	public function user(){
		return $this->belongsTo('App\User');
	}
	
}
