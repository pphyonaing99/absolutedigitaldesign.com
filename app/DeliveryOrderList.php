<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrderList extends Model
{
    protected $fillable = [
    	'delivery_order_id','product_id','stock_qty','reject_qty','reject_status'
    ];
    public function product(){
    	return $this->belongsTo('App\Product');
    }
}
