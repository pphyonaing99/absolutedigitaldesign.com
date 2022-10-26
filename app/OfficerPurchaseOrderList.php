<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficerPurchaseOrderList extends Model
{
    //
    protected $fillable = [
    	'regional_id','project_id','phase_id','site_id','warehouse_flag','regional_name','officer_purchase_order_id','product_id','purchase_request_id','purchase_request_no','request_qty','grn_sent_status','order_qty','now_qty'
    ];
    public function product(){
    	return $this->belongsTo('App\Product');
    }
    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }
    public function project(){
    	return $this->belongsTo('App\Project');
    }
}
