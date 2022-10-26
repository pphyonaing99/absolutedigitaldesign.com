<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HandtoolList extends Model
{
    protected $fillable= [
        'handtool_assign_id',
        'user_id',
        'handtool_id',
        'assigned_date',
        'return_date',
        'status'
    ];
    
    public function handtool_assign(){
        return $this->belongsTo('App\HandtoolAssign');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function handtool(){
        return $this->belongsTo('App\Handtool');
    }
}
