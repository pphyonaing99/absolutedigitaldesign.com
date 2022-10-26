<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
    	'category_id','sub_category','name','description','suppliers','country_of_origin',
    ];
    /*public function getSubCategoryAttribute($value){
    	return json_decode($value);
    }
    public function getSuppliersAttribute($value){
    	return json_decode($value);
    }*/

    public function sub_category(){
    	return $this->belongsToMany('App\SubCategory');
    }
    public function supplier(){
        return $this->belongsToMany('App\Supplier');
    }

    public function assignSupplier($supplier) {
		return $this->supplier()->attach($supplier);
	}
    public function assignSubCategory($supplier) {
		return $this->sub_category()->attach($supplier);
	}
  public function product(){
		return $this->belongsTo('App\Product');
	}
}
