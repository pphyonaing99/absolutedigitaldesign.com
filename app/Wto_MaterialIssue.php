<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wto_MaterialIssue extends Model
{
    //
    protected $fillable = [
		'warehouse_transfer_order_id', 'material_issue_id',
	];
    public function product(){
    	return $this->belongsTo('App\Product');
    }
    public function maissue(){
    	return $this->belongsTo('App\MaterialIssue');
    }
}
