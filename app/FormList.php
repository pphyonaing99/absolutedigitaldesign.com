<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormList extends Model
{
    //
    protected $fillable = [
		'form_name','prefix','check_by','approve_by','prepare_by','index_digit',
	];

    public function goodreceivenote(){
		return $this->belongsTo('App\GoodReceiveNote');
	}
    public function officerpo(){
		return $this->belongsTo('App\OfficerPurchaserOrder');
	}
    public function purchasereq(){
		return $this->belongsTo('App\WarehousePurchaseOrder');
	}
    public function role(){
		return $this->belongsTo('App\Role');
	}
}

