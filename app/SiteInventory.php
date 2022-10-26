<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteInventory extends Model {
	protected $fillable = [
		'product_id','model_number', 'name', 'measuring_unit', 'name', 'brand_name', 'delivered_qty', 'location', 'received_date', 'project_id', 'phase_id','flag'
	];
	
	public function product(){
	    return $this->belongsTo('App\Product');
	}
}
