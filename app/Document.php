<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
        'description',
        'project_id',
        'phase_id',
        'customer_id',
        'file',
    ];

    public function phase(){
        return $this->belongsTo('App\ProjectPhase');
    }
}
