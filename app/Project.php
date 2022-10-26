<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
	protected $fillable = [
		'project_name', 'customer', 'description', 'location', 'start_date', 'end_date','regional_warehouse_id','customer_id',
	];
	
	public function regional_warehouse(){
		return $this->belongsTo('App\RegionalWarehouse');
	}
	public function customer(){
		return $this->belongsTo('App\Customer');
	}
	public function officer(){
		return $this->belongsTo('App\OfficerPurchaseOrderList');
	}
	
}
