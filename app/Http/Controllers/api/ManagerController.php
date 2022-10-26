<?php

namespace App\Http\Controllers\api;

use App\Project;
use App\PhaseTask;
use App\ReportTask;
use App\ProjectPhase;
use App\SiteInventory;
use App\ReportTaskList;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIBaseController;

class ManagerController extends APIBaseController {
	public function project_list() {

		$projects = Project::all();

		return response()->json([
			'projects' => $projects,
		]);
	}

	public function store_project(Request $request) {

		$validator = Validator::make($request->all(), [
			'project_name' => 'required',
			'customer' => 'required',
			'description' => 'required',
			'location' => 'required',
			'start_date' => 'required|date',
			'end_date' => 'required|date|after:start_date',
		]);

		if ($validator->fails()) {
			return $this->sendFailResponse();
		}

		$project = Project::create([
			'project_name' => $request->project_name,
			'customer' => $request->customer,
			'description' => $request->description,
			'location' => $request->location,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
		]);

		return $this->sendSuccessResponse('data', $project);

	}

	//Project Phase

	public function store_phase(Request $request) {

		$project_id = $request->project_id;

		$project = Project::find($project_id);

		$validator = Validator::make($request->all(), [
			'phase_name' => 'required',
			'description' => 'required',
			'start_date' => 'required|date|after:' . $project->start_date,
			'end_date' => 'required|date|before:' . $project->end_date,
		]);

		if ($validator->fails()) {
			return $this->sendFailResponse();
		}

		$project_phase = ProjectPhase::create([
			'phase_name' => $request->phase_name,
			'description' => $request->description,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
			'user_id' => $request->user_id,
			'project_id' => $request->project_id,
		]);

		return $this->sendSuccessResponse('data', $project_phase);
	}
	public function check_phase_list(Request $request) {

		$project_id = $request->project_id;
		$user_id = $request->user_id;

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'project_id' => 'required',
		]);

		if ($validator->fails()) {
			return $this->sendFailResponse();
		}

		$phases = ProjectPhase::where('project_id', $project_id)->get();

		$tasks = PhaseTask::all();

		return $this->sendSuccessResponse('data', $phases);
	}
	public function task_list(Request $request) {

		$phase_id = $request->phase_id;

		$validator = Validator::make($request->all(), [
			'phase_id' => 'required',
		]);

		if ($validator->fails()) {
			return $this->sendFailResponse();
		}

		$tasks = PhaseTask::where('phase_id', $phase_id)->get();

		return $this->sendSuccessResponse('data', $tasks);
	}

	public function store_task(Request $request) {
		
		$phase_id = $request->phase_id;

		$phase = ProjectPhase::find($phase_id);

		$validator = Validator::make($request->all(), [
			'task_name' => 'required',
			'description' => 'required',
			'start_date' => 'required|date|after:' . $phase->start_date,
			'end_date' => 'required|date|before:' . $phase->end_date,
		]);

		if ($validator->fails()) {
			return $this->sendFailResponse();
		}

		$phase_task = PhaseTask::create([
			'task_name' => $request->task_name,
			'description' => $request->description,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
			'phase_id' => $phase_id,
			
		]);

		return $this->sendSuccessResponse('data', $phase_task);

	}

	//Finished Task or Unfinished Task
	public function store_reported_task(Request $request){


// 		return $request;
		$task_id = $request->task_id;

		$task = PhaseTask::find($task_id);

		// dd($request->photo);
		// return $request;


	
		// $photo_arr = [];
		// $photo = $request->file('photo');
		// foreach($photo as $eachpho)
		// {
		// 	$name = $eachpho->getClientOriginalName();
		// 	array_push($photo_arr,$name);
		// }
		
		

		// $str_pho = json_encode($photo_arr);
		
		// return $str_pho;
			
	   
	

		
    
		$validator = Validator::make($request->all(), [
			'finished_date' => 'required',
			'report_description' => 'required',
			// 'photo' => 'required',
			'checked_by' => 'required',
			'task_status' => 'required',

			// 'product_id' => 'required',
			// 'stock_qty' => 'required',
			'product_list' => 'required',
		

		]);
		
		if ($validator->fails()) {
			return $this->sendFailResponse("Wrong!!!");
		}

		$task_id = $request->task_id;

		$task = PhaseTask::find($task_id);
		$start_time = \Carbon\Carbon::parse($task->end_date);
		$finish_time = \Carbon\Carbon::parse($request->finished_date);



$result = $finish_time->diffInDays($start_time, false);
// dd($result);


if($request->progress == 100 || $request->complete == 1)
{
$task->complete = 1;
$task->status = 1;
$task->save();
		if($result == 0)
		{	
			$per_status = 1;
			$perfor = "on time";
		}
		elseif($result > 0)
		{
			$per_status = 2;
			$perfor = "early -".$result."days";
		}
		else
		{
			$per_status = 3;
			$results = $result * -1;
			$perfor = "late -".$results."days";
		}
}
elseif($request->progress < 100 && $result < 0)
{
	$per_status = 3;
	$results = $result * -1;
	$perfor = "late -".$task->end_date; 
}
else{

	$per_status = 0;

	$perfor = "in progress";
}

		

		$photo_arr = [];
		if($request->type == 1)
		{
		// if ($request->hasfile('photo')) {
		// 	// dd("hello");
		// 	$photo = $request->file('photo');
		// 	$name = $photo->getClientOriginalName();
		// 	$photo->move(public_path() . '/image/', $name);
		// 	$photo = $name;
		// }
		

		$photo = $request->file('photo');
		foreach($photo as $eachpho)
		{
			$name = $eachpho->getClientOriginalName();
			$eachpho->move(public_path() . '/image/', $name);
			$photo = $name;
			array_push($photo_arr,$photo);
		}

		
		
		
	}
	else{
		$photo = $request->file('photo');
		foreach($photo as $eachpho)
		{
			$name = $eachpho->getClientOriginalName();
			$eachpho->move(public_path() . '/video/', $name);
			$photo = $name;
			array_push($photo_arr,$photo);

		}
		// if ($request->hasfile('photo')) {
			
			// $photo = $request->file('photo');
			// $name = $photo->getClientOriginalName();
			// $photo->move(public_path() . '/video/', $name);
			// $photo = $name;
			// array_push($photo_arr,$photo);
		// }
	}
	// dd(json_encode($photo_arr));
		// dd($request->product_list);
		// dd($str_pho);
		$qty_array = [];
		$product_array = json_decode($request->product_list);
		// dd($product_array);
		foreach($product_array as $qtys)
		{
			
			array_push($qty_array,$qtys->stock_qty);
		}
		
		$total_qty = array_sum($qty_array);
		// dd($total_qty);
		
		//sub photo	
		// $subphoto = $request->file('photo');
		// dd($subphoto);
		// $subArray = [];
        //     foreach($subphoto as $photosub)
        //     {
				
               
        //         $name = $photosub->getClientOriginalName();
        //         // $subimage =  time()."-".$name;
        //         array_push($subArray,$name);
        //         $photosub->move(public_path() . '/image/', $name);
				
            
		// 	}
            
        //     $subString = json_encode($subArray);
		// 	dd($subString);
		// end sub photo

		$file_count = count($photo_arr);

		$progresss = $request->progress."%";
		$report_task = ReportTask::create([
			'task_id' => $request->task_id,
			'report_description' => $request->report_description,
			'finished_date' => $request->finished_date,
			'file_type' => $request->type,
			'file_count' => $file_count,
			'photo' =>json_encode($photo_arr),
			// 'photo' => $photo_arr,
			'checked_by' => $request->checked_by,
			'task_status' => $request->task_status,

			'product_list' =>  json_encode($request->product_list),
			'total_stock_qty' => $total_qty,
			'type' => $request->type,
			'progress' => $progresss,
			'performance'=> $perfor,
			'performance_status' => $per_status,

		]);

		// $report_task->photo =  $photo;
		$report_task->save();
		
		foreach ($product_array as $product) {
			// dd($product->product_id);
			$material_request_lists = ReportTaskList::create([
				'product_id' => $product->product_id,
				'report_task_id' => $report_task->id,
				'stock_qty' => $product->stock_qty,
			]);
		}

		//continue...........
		foreach($photo_arr as $eachphoto)
		{
		DB::table('report_task_files')->insert([
			'report_task_id' => $report_task->id,
			'file' => $eachphoto,
		]);
	}
		//end continue.......

		// $task = PhaseTask::find($request->task_id);
		// $phase = ProjectPhase::find($task->phase_id);

		// $site_inventory = SiteInventory::where('product_id',$request->product_id)->first();
		
		// $site_inventory->delivered_qty = $site_inventory->delivered_qty - $report_task->stock_qty;
		// $site_inventory->save();
		
		// $task->status = 1;
		// $task->save();

		return $this->sendSuccessResponse('data',$report_task);	
	}

	
}
