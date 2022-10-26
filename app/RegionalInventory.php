<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionalInventory extends Model
{
    protected $fillable = [
    	'product_id',
    	'regional_warehouse_id',
    	'model_number',  
    	'measuring_unit', 
    	'name',  
    	'transfer_qty', 
    	'reserved_qty' , 
    	'location', 
    	'received_date', 
    	'project_id', 
    	'phase_id',
    	'flag',
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
}
