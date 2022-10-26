<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehousePurchaseOrder extends Model
{
    protected $fillable = [
    	'regional_name','destination_flag','destination_regional_id','project_id','phase_id','item_list','required_date','sent_status','status','priority','material_request_id','sale_order_id'
    ];

    public function getItemListAttribute($value){
    	return json_decode($value);
    }
    public function warehouse_purchase_order_list(){
    	return $this->hasOne('App\WarehousePurchaseOrderList');
    }
    public function project(){
        return $this->belongsTo('App\Project');
    }
    public function phase(){
    	return $this->belongsTo('App\ProjectPhase');
    }
    public function formlist(){
    	return $this->belongsTo('App\FormList');
    }
    public function regional(){
    	return $this->belongsTo('App\RegionalWarehouse');
    }
}
