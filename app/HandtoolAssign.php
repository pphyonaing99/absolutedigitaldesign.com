<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HandtoolAssign extends Model
{
    protected $fillable = [
        'phase_id',
        'user_id',
        'handtool_list',
        'site_status',
        'assigned_qty',
        'returned_qty',
        'return_status',
        'return_date',
        'status',
        'site_status'
    ];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function phase(){
        return $this->belongsTo('App\ProjectPhase');
    }
}
