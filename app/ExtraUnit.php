<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraUnit extends Model
{
    protected $fillable = [
    	'product_id','name','basic_unit_qty','retail_price','wholesale_price','stock_qty','reorder_qty','discount_flag','discount_type',
    ];
}
