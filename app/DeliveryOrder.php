<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $fillable = [
    	'material_issue_id','ware_transfer_order_id','deliver_status','receive_person','phone','material_request_id','purchase_order_id','project_id','phase_id','item_list','delivery_date','approve','status','user_id','location','do_no','reject_status'
    ];

    public function getItemListAttribute($value){
    	return json_decode($value);
    }
    public function product(){
    	return $this->belongsTo('App\Product','product_id');
    }
    public function project(){
    	return $this->belongsTo('App\Project');
    }
    public function purchase_order(){
        return $this->belongsTo('App\PurchaseOrder');
    }
    public function phase(){
    	return $this->belongsTo('App\ProjectPhase');
    }
    public function material_request(){
    	return $this->belongsTo('App\MaterialRequest');
    }

}
