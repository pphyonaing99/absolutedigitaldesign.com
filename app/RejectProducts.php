<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RejectProducts extends Model
{
    
    protected $fillable = [
    	'grn_no',
        'product_id',
        'product_name',
        'good_receive_note_id',
        'regional_name',
        'date',
        'type',
        'warehouse_flag',
        'quantity',
        'category_name',
        'supplier',
        'purchase_price',
        'project_phase_id',
        'work_site_id',
        'remark'

    ];
    
}

