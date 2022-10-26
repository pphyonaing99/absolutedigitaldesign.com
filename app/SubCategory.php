<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
    	'category_id','name','description',
    ];
    public function category(){
    	return $this->belongsTo('App\Category');
    }
    public function brand(){
    	return $this->belongsToMany('App\Brand');
    }
}
