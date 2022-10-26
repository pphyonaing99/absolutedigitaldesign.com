<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestListHistory extends Model
{
    protected $fillable = [
    	'product_id','material_request_id','request_qty',
    ];
}
