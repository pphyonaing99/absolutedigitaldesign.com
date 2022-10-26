<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportTask extends Model
{
    protected $fillable = [

    	'product_id','stock_qty','product_list','total_stock_qty','task_id','finished_date','report_description','photo','checked_by','task_status','type','progress','performance','performance_status','file_count','file_type'

    ];
    public function task(){
    	return $this->belongsTo('App\PhaseTask');
    }
    public function product(){
    	return $this->belongsTo('App\Product');
    }

}
