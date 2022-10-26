<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodReceiveNote extends Model
{
    protected $fillable = [
        
        'grn_no','date','prefix_syntax','index_digit','approve_status','type','warehouse_flag','project_phase_id','work_site_id','total_qty','change_status','project_name',
        
        ];
        
    public function product(){
        
        return $this->belongsToMany('App\Product')->withPivot('id','quantity','category_name','supplier','purchase_price','remark','change_status','product_id');
    }
    
    public function warehouse_purchase_order(){
        
        return $this->belongsToMany('App\WarehousePurchaseOrder');
    }

    public function regional(){
        return $this->belongsToMany('App\RegionalWarehouse')->withPivot('good_receive_note_id','regional_warehouse_id');
    }

      
    public function formlist(){
    	return $this->belongsTo('App\FormList');
    }

        
}
