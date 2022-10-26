<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportTaskList extends Model
{
    //
    protected $fillable = [
    	'report_task_id','product_id','stock_qty',
    ];
    public function productreport(){
    	return $this->belongsTo('App\Product');
    }
}
