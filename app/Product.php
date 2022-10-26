<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	protected $fillable = [

		'serial_number','category_id','subcategory_id','brand_id','shelve_id','model_number', 'measuring_unit', 'name', 'stock_qty','minimum_order_qty', 'reorder_qty', 'purchase_price','retail_price','wholesale_price','discount_flag','discount_type' ,'location', 'reg_date',



	];

	public function brand(){
		return $this->belongsTo('App\Brand');
	}
	public function brands(){
		return $this->belongsTo('App\Brand');
	}
	public function shelve(){
	    return $this->belongsTo('App\Shelve');
	}

	public function product_name(){
		return $this->belongsTo('App\ReportTask');
	}

	public function category(){
		return $this->belongsTo('App\Category');
	}
	
	

}
