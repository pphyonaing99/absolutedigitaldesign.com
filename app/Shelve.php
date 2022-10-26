<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shelve extends Model
{
    protected $fillable = [
            'name','description','zone_id'
        ];
    
    public function zone(){
        return $this->belongsTo('App\Zone');
    }
}
