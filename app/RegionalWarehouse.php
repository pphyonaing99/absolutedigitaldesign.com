<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionalWarehouse extends Model
{
    protected $fillable = [
    	'warehouse_name',
    	'region',
    	'country',
    	'location_address',
    	'area',
    	'capacity',
    	'employee_id',
    	'project_id',
		'photo',
    ];

    public function employee() {
        return $this->belongsTo('App\Employee');
    }
	public function projects(){
    	return $this->belongsToMany('App\Project');
    }
}
