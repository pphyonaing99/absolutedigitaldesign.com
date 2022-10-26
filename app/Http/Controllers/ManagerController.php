<?php

namespace App\Http\Controllers;
use App\Employee;
use App\Equipment;
use App\Part;
use App\Product;
use App\User;
use App\Brand;
use App\Role;
use App\DiscountType;
use App\MaterialIssue;
use App\MaterialIssueList;
use App\WarehoueTransferOrder;
use App\ExtraUnit;
use App\ReportTask;
use App\PhaseTask;
use App\GoodReceiveNote;
use App\ProjectPhase;
use App\DeliveryOrder;
use App\Zone;
use App\Category;
use App\ReportTaskList;
use App\SiteInventory;
use App\FormList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManagerController extends Controller {

	//Product

	public function draganddropthis()
	{
		
		return view('draganddrop');
	}

	public function product_list() {
		$products = Product::orderBy('id','desc')->get();
		$zones = Zone::all();
		return view('Manager/Product/product_list', compact('products','zones'));
	}

	public function create_product($shelve_id) {

		$brands = Brand::all();

		$discount_types = DiscountType::all();
		
		$shelve_id = $shelve_id;
		
		$categories = Category::all();

		return view('Manager/Product/create_product',compact('brands','discount_types','shelve_id','categories'));
	}

	public function store_product(Request $request) {
		dd($request->all());
		$extra_units = $request->extra_unit;
		
		/*$validator = Validator::make($request->all(), [
			'model_number' => 'required',
			'name' => 'required',
			'stock_qty' => 'required',
			'brand_name' => 'required',
			'reg_date' => 'required',
			'location' => 'required',
			'measuring_unit' => 'required',
			'reorder_quantity' => 'required',
			'purchase_price' => 'required',
			'retail_price' => 'required',
			'wholesale_price' => 'required',
		]);

		if ($validator->fails()) {
			alert()->info("Please Fill all Field!");
		}*/
		$srn_num = "SRN-" . $request->serial_number;
		$product = Product::create([
		    'shelve_id' => $request->shelve_id??null,
		    'category_id' => $request->category_id??null,
		    'subcategory_id' => $request->subcategory_id??null,
			'brand_id' => $request->brand_id,
			'model_number' => $request->model_number,

			'name' => $request->name,
			'stock_qty' => $request->stock_qty,
			'brand_name' => $request->brand_name,
			'reg_date' => $request->reg_date,
			'location' => $request->location,
			'measuring_unit' => $request->measuring_unit,
			'minimum_order_qty' => $request->minimum_order_qty,
			'reorder_qty' => $request->reorder_qty,
			'purchase_price' => $request->purchase_price.'-'.$request->purchase_price_currency,
			'retail_price' => $request->retail_price.'-'.$request->retail_price_currency,
			'wholesale_price' => $request->wholesale_price.'-'.$request->wholesale_price_currency,
			'discount_flag' => 0,  
			'discount_type' => $request->discount_type,
			'serial_number' => $srn_num,
		]);


		// if($extra_units != null){
		//     foreach ($extra_units as $extra_unit) {
    	// 		$extra = json_decode($extra_unit);
    			
    	// 		foreach ($extra as $key => $value) {
    				
    	// 			ExtraUnit::create([
    	// 				'product_id' => $product->id,
    	// 				'name' => $value->extra_measuring_unit,
    	// 				'basic_unit_qty' => $value->basic_unit_qty,
    	// 				'stock_qty' => $value->extra_stock_qty,
    	// 				'reorder_qty' => $value->extra_reorder_qty,
    	// 				'retail_price' => $value->extra_retail_price.'-'.$value->extra_wholesale_price_currency,
    	// 				'wholesale_price' => $value->extra_retail_price.'-'.$value->extra_wholesale_price_currency,
    	// 				'discount_flag' => "on",
    	// 				'discount_type' => 1,
    	// 			]);
    
    	// 		}
    	// 	}
		// }
		// return back();
		return redirect()->route('shelve_product_list',['shelve_id' => 1]);
	}

	//Part
	public function store_part(Request $request) {
		$validator = Validator::make($request->all(), [
			'serial_number' => 'required',
			'name' => 'required',
			'stock_qty' => 'required',
			'brand_name' => 'required',
			'reg_date' => 'required',
		]);

		if ($validator->fails()) {
			return "failed";
		}
		$product_id = $request->product_id;

		$part = Part::create([
			'serial_number' => $request->serial_number,
			'name' => $request->name,
			'stock_qty' => $request->stock_qty,
			'brand_name' => $request->brand_name,
			'reg_date' => $request->reg_date,
			'product_id' => $product_id,
		]);
		return redirect()->route('product_list');
	}

	//Equipment

	public function equipment_list() {

		$equipments = Equipment::all();

		return view('Manager/Equipment/equipment_list', compact('equipments'));
	}
	public function create_equipment() {

		return view('Manager/Equipment/create_equipment');
	}

	public function store_equipment(Request $request) {

		$validator = Validator::make($request->all(), [
			'serial_number' => 'required',
			'name' => 'required',
			'stock_qty' => 'required',
			'brand_name' => 'required',
			'reg_date' => 'required',
		]);

		if ($validator->fails()) {
			return "failed";
		}

		$item_id = $request->item_id;

		$equipment = Equipment::create([
			'serial_number' => $request->serial_number,
			'name' => $request->name,
			'stock_qty' => $request->stock_qty,
			'brand_name' => $request->brand_name,
			'reg_date' => $request->reg_date,
		]);
		return redirect()->route('equipment_list');
	}
	//Employee
	public function employee_list() {

		$employees = Employee::all();

		return view('Manager/Employee/employee_list', compact('employees'));
	}
	public function create_employee() {

		$roles = Role::all();

		return view('Manager/Employee/create_employee', compact('roles'));
	}
	public function show_form_lists()
	{
		//for projectmanager
		$dothischeck = FormList::where('id',1)->where('check_by',1)->get();
		$dothisprepare = FormList::where('id',1)->where('prepare_by',1)->get();
		$dothisapprove = FormList::where('id',1)->where('approve_by',1)->get();
		// dd($dothischeck);
		
		
		
				session()->put('formlist_check',$dothischeck);
				session()->put('formlist_approve',$dothisapprove);
				session()->put('formlist_prepare',$dothisprepare);
				
		
		
		
		// dd($dothischeck);
		// dd($dothischeck);
		// $dothisprepare = FormList::where('prepare_by',$role_id->role_id)->get();
		// dd($dothisprepare);
		// $dothisapprove = FormList::where('approve_by',$role_id->role_id)->get();
		
		// $request->session()->put('formlist_check',$dothischeck);
		// $request->session()->put('formlist_approve',$dothisapprove);
		// $request->session()->put('formlist_prepare',$dothisprepare);



		//end
				$form = FormList::all();
				$roles = Role::all();
				return view('Manager/process_forms/form_list',compact('form','roles'));
		
	}
	public function create_form()
	{
		$roles = Role::all();
		return view('Manager/process_forms/create_form',compact('roles'));
	}
	public function store_form(Request $request)
	{
		// dd($request->all());
		$validator = Validator::make($request->all(), [
			'form_name' => 'required',
			'prefix' => 'required',
			'check_role_id' => 'required',
			'approve_role_id' => 'required',
			'prepare_role_id' => 'required',
			
		]);
			
		if ($validator->fails()) {
			return "failed";
		}
		$Form = FormList::create([
			'form_name' => $request->form_name,
			'prefix' => $request->prefix,
			'check_by' => $request->check_role_id,
			'prepare_by' => $request->prepare_role_id,
			'approve_by' => $request->approve_role_id,
			

		]);
		alert()->success('Successfully Store!');
		return redirect()->back();
	}

	public function update_form(Request $request)
	{
		// dd($request->all());
		$count_index = $request->index;
		$form_update = FormList::find($request->form_id);
		$form_update->form_name = $request->form_name;
		$digit = "";
		for($i = 1;$i<=$count_index;$i++)
		{
			$digit .= "0";
		}
		// dd($digit);
		$form_update->index_digit = $digit;
		$form_update->prefix = $request->prefix;
		$form_update->check_by = $request->check_role_id;
		$form_update->approve_by = $request->approve_role_id;
		$form_update->prepare_by = $request->prepare_role_id;
		$form_update->save();
		
		if($request->form_id == 1)
		{
			$good_prefix_update = GoodReceiveNote::all();
			foreach($good_prefix_update as $prefix)
			{
				$prefix->prefix_syntax = $request->prefix;
				$prefix->index_digit = $request->index;
				$prefix->save();
			}
		}
		elseif($request->form_id == 5)
		{
			$ware_transfer_order = WarehoueTransferOrder::all();
			foreach($ware_transfer_order as $prefix)
			{
				$prefix->prefix_syntax = $request->prefix;
				$prefix->index_digit = $request->index;
				$prefix->save();
			}


		}
		elseif($request->form_id == 4)
		{
			$material_issue = MaterialIssue::all();
			foreach($material_issue as $prefix)
			{
				$prefix->prefix_syntax = $request->prefix;
				$prefix->index_digit = $request->index;
				$prefix->save();
			}


		}
		
		alert()->success('Successfully Update!');
		$form = FormList::all();
		$roles = Role::all();
		// return redirect()->route('show_form_list');
		return redirect()->to('/show_form_list'); 
	}

	public function store_employee(Request $request) {
		// dd($request->all());
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'address' => 'required',
			'phone' => 'required',
			'photo' => 'required',
			'employed_date' => 'required',
			'salary' => 'required',
			'email' => 'required',
			'password' => 'required',
			'role_id' => 'required',
		]);
			
		if ($validator->fails()) {
			return "failed";
		}

		if ($request->hasfile('photo')) {

			$photo = $request->file('photo');
			$name = $photo->getClientOriginalName();
			$photo->move(public_path() . '/image/', $name);
			$photo = $name;
		}

		

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => \Hash::make($request->password),
			'remember' => Str::random(60),
			// 'work_site_id' => 2,
			'work_site_id' => null,

		]);

		$employee = Employee::create([
			'name' => $request->name,
			'address' => $request->address,
			'phone' => $request->phone,
			'photo' => $photo,
			'employed_date' => $request->employed_date,
			'salary' => $request->salary,
			'user_id' => $user->id,
			'role' => $request->role_id,
		]);

		

		$user->assignRole($request->role_id);
		// dd("hello");
		$employee_code = "EPY" . sprintf("%04s", $employee->id);
		$employee->employee_code = $employee_code;
		$employee->save();

		return redirect()->route('employee_list');
	}

	public function CheckWarehouseTransfer(){

    	$material_issues = MaterialIssue::orderBy('approve','asc')
    			->orderBy('delivery_order_status','asc')
    			->orderBy('approve_delivery_order','asc')
    			->get();

    	$material_issue_list = MaterialIssueList::all();

    	return view('Manager/WarehouseTransfer/warehouse_transfer',compact('material_issues','material_issue_list'));

	}
	public function ApproveWarehouseTransfer(Request $request){

		$material_issue = MaterialIssue::find($request->material_issue_id);
		$material_issue->approve = 1;
		$material_issue->save();

		return response()->json("Success");

	}
	public function ApproveDeliveryOrder(Request $request){

		$material_issue = MaterialIssue::find($request->material_issue_id);
		$material_issue->approve_delivery_order = 1;
		$material_issue->save();

		$delivery_order = DeliveryOrder::where('material_issue_id',$material_issue->id)->first();
		$delivery_order->approve = 1;
		$delivery_order->save();

		return response()->json("Success");

	}
	public function reportTask(){

		// $report_tasks = ReportTask::where('task_status',2)->get();
		$report_tasks = ReportTask::where('task_status',1)->get();
		return view('Manager/Report/report_task',compact('report_tasks'));

	}
	public function reportProduct_minus(Request $request)
	{
		// dd($request->all());
		$product = ReportTask::find($request->report_id);
		// dd($product);
		$report_pro = ReportTaskList::where('report_task_id',$request->report_id)->get();
		foreach($report_pro as $repo)
		{
			
			$siteInvent = SiteInventory::where('product_id',$repo->product_id)->first();
			
			$siteInvent->delivered_qty = $siteInvent->delivered_qty - $repo->stock_qty;
			$siteInvent->save();
		}
		
		
		$product->change_status = 5;
		$product->save();
		
		return back();
	}
	public function report_list(){

        $site_inventories = SiteInventory::all();
        
        $tasks = PhaseTask::all();

		$report_tasks = ReportTask::where('task_status',2)->get();

		return view('Manager/Report/report_list',compact('report_tasks','site_inventories','tasks'));

	}
	
	//Finished Task or Unfinished Task
	public function store_reported_task(Request $request){
	       
		$task_id = $request->task_id;
        
		$task = PhaseTask::find($task_id);

		$validator = Validator::make($request->all(), [
			'finished_date' => 'required',
			'report_description' => 'required',
			'product_list' => 'required',
			// 'photo' => 'required',
			/*'checked_by' => 'required',
			'task_status' => 'required',*/
			// 'product_id' => 'required',
			// 'stock_qty' => 'required',
		]);

		if ($validator->fails()) {
			alert()->error('Something wrong');
		}

		if ($request->hasfile('photo')) {

			$photo = $request->file('photo');
			$name = $photo->getClientOriginalName();
			$photo->move(public_path() . '/image/', $name);
			$photo = $name;
			
		}
		
		$report_task = ReportTask::create([
			'task_id' => $request->task_id,
			'report_description' => $request->report_description,
			'finished_date' => $request->finished_date,
			'photo' => $photo,
			'checked_by' => session()->get('user')->name,
			'task_status' => 1,
			'product_list' =>1,
			// 'product_id' => $request->product_id,
			// 'stock_qty' => $request->stock_qty,
		]);

		$report_task->photo = $photo;
		$report_task->save();


		$task = PhaseTask::find($request->task_id);
		$phase = ProjectPhase::find($task->phase_id);

		$site_inventory = SiteInventory::where('product_id',$request->product_id)
		    ->where('phase_id',$phase->id)
		    ->first();
		
		$site_inventory->delivered_qty = $site_inventory->delivered_qty - $report_task->stock_qty;
		$site_inventory->save();
		
		$task->status = 1;
		$task->save();

		return redirect()->route('report_list');
	}
}
