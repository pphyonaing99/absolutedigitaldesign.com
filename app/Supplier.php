<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
    	'supplier_code','email','name','phone','address','category_id','available_brands'
    ];

    public function getAvailableBrandAttribute($value){
    	return json_decode($value);
    }

    public function brand(){
    	return $this->belongsToMany('App\Brand');
    }

    public function assignBrand($brand) {
		return $this->brand()->attach($brand);
	}


}
