<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectItem extends Model
{
    //
    protected $fillable = [
    	'grn_id',
        'do_id',
        'do_list_id',
        'product_id',
        'grn_product_id',
        'regional_id',
        'regional_id',
        'reject_date',
        'type',
        
        'reject_qty',
        
        'supplier',
        
        
        'remark',
        'status',

    ];

    public function product(){
    	return $this->belongsTo('App\Product');
    }
    public function project(){
    	return $this->belongsTo('App\Project');
    }
    public function phase(){
    	return $this->belongsTo('App\ProjectPhase');
    }
    public function regional(){
        return $this->belongsTo('App\RegionalWarehouse');
    }

}
