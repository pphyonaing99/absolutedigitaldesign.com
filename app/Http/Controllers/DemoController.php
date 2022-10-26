<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostsQueryExport;


class DemoController extends Controller
{
    //
    public function export(Request $request){
        $taskexcel = $request->taskID;
        $tname     = $request->taskname;
        //dd($tname);


        return Excel::download(new PostsQueryExport($taskexcel),'bill.xlsx');
    }
}
