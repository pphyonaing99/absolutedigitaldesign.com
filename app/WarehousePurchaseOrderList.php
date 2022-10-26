<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehousePurchaseOrderList extends Model
{
    protected $fillable = [
    	'warehouse_purchase_order_id','product_id','stock_qty','material_request_id','ordered_qty','now_qty'
    ];
    public function product(){
    	return $this->belongsTo('App\Product');
    }

    public function warehouse_purchase_order(){
    	return $this->belongsTo('App\WarehousePurchaseOrder');
    }
    public function project(){
        return $this->belongsTo('App\Project');
    }
}
