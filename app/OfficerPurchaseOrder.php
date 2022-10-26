<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficerPurchaseOrder extends Model
{
    protected $fillable = [
    	'po_no','total_qty','approve','mail_sent','po_date','item_list','delivery_address','supplier_id','warehouse_status','status',
    ];
    public function getItemListAttribute($value){
    	return json_decode($value);
    }
    public function supplier(){
    	return $this->belongsTo('App\Supplier');
    }
    public function purchase_request(){
    	return $this->belongsTo('App\WarehousePurchaseOrder');
    }
    public function project(){
    	return $this->belongsTo('App\Project');
    }
    public function formlist(){
    	return $this->belongsTo('App\FormList');
    }
}
