<?php

namespace App\Exports;

use App\PhaseTask;
use App\ReportTask;
use App\ProjectPhase;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PostsQueryExport implements FromQuery,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $taskid)
    {
        $this->ID = $taskid;
        
        //dd($this->name);
        
       
     
    }  
    public function query()
    {    
       

        //  return DB::table('report_tasks')
        //               ->join('phase_tasks','report_tasks.task_id','=','phase_tasks.id')
        //               ->where('report_tasks.task_id','=',$this->ID)
        //               ->select('phase_tasks.task_name','report_tasks.report_description','report_tasks.stock_qty','report_tasks.finished_date')
                      
        //               ->orderby('report_tasks.id');
                      
    
        return   DB::table('report_tasks')
                        ->select('phase_tasks.phase_id')
                        ->join('phase_tasks','report_tasks.task_id','=','phase_tasks.id')
                        ->where('report_tasks.task_id','=',$this->ID)
                        ->select('project_phases.project_id')
                        ->join('project_phases','project_phases.id','=','phase_tasks.phase_id')
                        ->select('projects.project_name','project_phases.phase_name','phase_tasks.task_name','report_tasks.report_description','report_tasks.stock_qty','report_tasks.finished_date')
                        ->join('projects','projects.id','=','project_phases.project_id')
                        ->orderby('report_tasks.id');
                        
        //dd($result);

                        // ->join('project_phases','project_phases.id','=','phase_tasks.phase_id')
                        // ->select('project_phases .*')
                        // ->orderby('report_tasks.id');
               
        
    }
    public function headings():array{
        return [
            'Project Name',
            'Phase Name',

            'Task Name',
            'Report Description',
            'Stock Qty',
            
            'Finished Date',
            
            
        ];
    }
  
   
}

