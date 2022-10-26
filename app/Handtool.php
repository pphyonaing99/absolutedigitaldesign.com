<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handtool extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'brand_id',
        'serial_number',
        'supplier_id',
        'model',
        'purchase_date',
        'shelve_id',
        'purchase_price',
        'selling_price',
        'description',
        'status'
    ];
    
    public function category(){
        return $this->belongsTo('App\Category');
    }
    public function brand(){
        return $this->belongsTo('App\Brand');
    }
    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }
    public function shelve(){
        return $this->belongsTo('App\Shelve');
    }
}
