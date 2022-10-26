<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleOrderList extends Model
{
    protected $fillable = [
    	'sale_order_id','product_id','stock_qty',
    ];
    
    public function product(){
    	return $this->belongsTo('App\product');
    }
}
