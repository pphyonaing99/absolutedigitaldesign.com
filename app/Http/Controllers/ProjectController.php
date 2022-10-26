<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Project;
use App\Document;
use App\Employee;
use App\PhaseTask;
use App\ReportTask;
use App\ProjectPhase;
use App\ReportTaskList;
use App\SiteInventory;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller {

	//project
	public function project_list() {
		
		$users = User::all();

		$projects = Project::all();

		return view('Manager/Project/project_list', compact('projects', 'users'));
	}
	public function create_project() {
		return view('Manager/Project/create_project');
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
			return "failed";
		}

		Project::create([
			'project_name' => $request->project_name,
			'customer' => $request->customer,
			'description' => $request->description,
			'location' => $request->location,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
		]);

		return redirect()->route('project_list');

	}

	//Project Phase

	public function store_phaseNow(Request $request) {
		// dd($request->all());
		$project_id = $request->project_id;

		$project = Project::find($project_id);

		$validator = Validator::make($request->all(), [
			'phase_name' => 'required',
			'description' => 'required',
			'start_date' => 'required|date|after:' . $project->start_date,
			'end_date' => 'required|date|before:' . $project->end_date,
		]);

		if ($validator->fails()) {
			alert()->error("Your start_date and end_date are not Between Project Date");
			return redirect()->back();
		}

		$projects = Project::find($request->project_id);
		$affected = DB::table('users')
              ->where('id',$request->user_id)
			  
              ->update(['work_site_id' => $request->project_id]);

		ProjectPhase::create([
			'phase_name' => $request->phase_name,
			'description' => $request->description,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
			'user_id' => $request->user_id,
			'project_id' => $request->project_id,
		]);

		return redirect()->route('project_list');

	}

	public function store_phase(Request $request) {
		dd($request->all);
		$project_id = $request->project_id;

		$project = Project::find($project_id);

		$validator = Validator::make($request->all(), [
			'phase_name' => 'required',
			'description' => 'required',
			// 'start_date' => 'required|date|after:' . $project->start_date,
			// 'end_date' => 'required|date|before:' . $project->end_date,
		]);

		if ($validator->fails()) {
			alert()->error("Your start_date and end_date are not Between Project Date");
			return redirect()->back();
		}

		$projects = Project::find($request->project_id);
		$affected = DB::table('users')
              ->where('id',$request->user_id)
			  
              ->update(['work_site_id' => $request->project_id]);

		ProjectPhase::create([
			'phase_name' => $request->phase_name,
			'description' => $request->description,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
			'user_id' => $request->user_id,
			'project_id' => $request->project_id,
		]);

		return redirect()->route('project_list');
	}
	public function check_phase_list(Request $request, $project_id) {

		$phases = ProjectPhase::where('project_id', $project_id)->get();

		$tasks = PhaseTask::all();
		
		$documents = Document::all();

		return view('Manager/Project/check_phase_list', compact('phases', 'tasks','documents'));
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
			return "Failed";
		}

		PhaseTask::create([
			'task_name' => $request->task_name,
			'description' => $request->description,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
			'phase_id' => $phase_id,
			'status' => 0
		]);

		alert()->success("Successfully Added Task!");
		return redirect()->route('check_phase_list', ['project_id' => $request->project_id]);
	}

	public function check_task_report(Request $request,$task_id){

		$report_task = ReportTask::where('task_id',$task_id)->first();

		$task = PhaseTask::find($task_id);

		$phase = ProjectPhase::find($task->phase_id);

		$project = Project::find($phase->project_id);

		$employee = User::find($phase->user_id);

		return view('Manager/Project/check_report_task',compact('report_task','task','phase','project'));

	}


	public function check_detail($id){
		$phaseID = $id;
		
		// dd($phaseID);
		
		$taskdetails = PhaseTask::where('phase_id',$phaseID)->get();
		// dd($taskdetails);
		$users = ProjectPhase::where('id',$phaseID)->get();
		//dd($users);
		$phasename = ProjectPhase::find($phaseID);
		// dd($phasename->project_id);
		$projectname = Project::find($phasename->project_id);
		// dd($projectname->projectname);

		$table_one = User::all();
						
		$product_all = Product::all();
		
		
						
						

		//join
		// $users = DB::table('users')
        //     ->join('contacts', 'users.id', '=', 'contacts.user_id')
        //     ->join('orders', 'users.id', '=', 'orders.user_id')
        //     ->select('users.*', 'contacts.phone', 'orders.price')
		// 	->get();
			
		// 	DB::table('uploads')
		// 	->select('uploads.id','comments.file_id',' comments.comment', 'users.id', 'comments.user', 'users.name')
		// 	->leftJoin('comments','uploads.id','=','comments.file_id')
		// 	->leftJoin('users','users.id','=','comments.user')
		// 	->get();

		//endjoin
		
		$product = Product::all();
		
		$reports = ReportTask::all();
		
		$report_task_list = ReportTaskList::all();
		
		$onlyphoto = DB::table('report_task_files')->get();
		return view('Manager/Project/check_task_detail',compact('report_task_list','onlyphoto','product_all','taskdetails','projectname','phasename','reports','product','table_one','users'));
	}
	
	public function approveqty(Request $request,$id){
		
		$ID = $id;
		//dd($ID);
		$productID = ReportTask::find($ID);
		//dd($productID->stock_qty);
		$site = SiteInventory::find($productID->product_id);

		$productName = $productID->product->name;
		// dd($productName);
		$site->delivered_qty = $site->delivered_qty - $productID->stock_qty;
		
		//dd($site);
		$site->save();
		
		// $material_issue = MaterialIssue::find($request->material_issue_id);
		// $material_issue->approve = 1;
		// $material_issue->save();
		alert()->success("Successfully Approve!");
		return back();
		

		
		
		
	}
}

// $studentid = Student::findOrFail($request->id);
//  $school_class = $studentid->school_class->name;

