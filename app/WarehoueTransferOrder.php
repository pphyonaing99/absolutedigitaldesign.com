<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehoueTransferOrder extends Model
{
    //
    protected $fillable = [
    	'warehouse_transfer_no','prefix_syntax','index_digit','date','total_qty','wto_regional_id','deliver_status','accept_status'
    ];
    public function product(){
    	return $this->belongsTo('App\Product');
    }
    public function project(){
    	return $this->belongsTo('App\Project');
    }
    public function regional(){
        return $this->belongsTo('App\RegionalWarehouse');
    }
}
