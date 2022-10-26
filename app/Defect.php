<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    protected $fillable = [
		'product_id',
		'qty',
		'comment',
		'extra_unit_id',
		'defect_date',
		'user_id',
		'purchase_order_id',
	];
	
	public function product(){
	    return $this->belongsTo('App\Product');
	}
	public function user(){
	    return $this->belongsTo('App\User');
	}
}
