<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MaterialIssue;
use App\MaterialIssueList;
use App\ProjectPhase;
use App\DeliveryOrder;
use App\DeliveryOrderList;
use App\WarehoueTransferOrder;
use App\Product;
use App\Project;
use App\User;
use Illuminate\Support\Facades\DB;
use App\PurchaseOrder;
use App\MaterialRequest;
use App\OfficerPurchaseOrder;
use App\RegionalWarehouse;
use App\RegionalInventory;
use Illuminate\Support\Facades\Validator;

class MaterialIssueController extends Controller
{
    public function material_issue(){

        $regionals = RegionalWarehouse::all();

    	$material_issues = MaterialIssue::where('warehouse_transfer_status',0)->where('approve',1)->orderBy('regional_warehouse_id','asc')->get();

    	$material_issue_list = MaterialIssueList::all();
    	
    	$material_requests = MaterialRequest::all();

        $product = Product::all();

        $blur_po = PurchaseOrder::all();

        $material_request = MaterialRequest::all();

        $user = User::all();

        $prefix = WarehoueTransferOrder::all();
        foreach($prefix as $pre)
        {
            $prefix_syntax = $pre->prefix_syntax;
            $index_digit = $pre->index_digit;
            $digit = "";
            for($i = 1;$i<=$pre->index_digit;$i++)
		{
			$digit .= "0";
		}
            
        }

    	return view('Warehouse/MaterialIssue/material_issue',compact('index_digit','prefix_syntax','digit','user','material_request','blur_po','product','regionals','material_issues','material_issue_list','material_requests'));
    }

    public function showproject(Request $request)
    {
        $material_issue = MaterialIssue::find($request->material_issue_id);
       
        $project = Project::find($material_issue->project_id);
        $phase = ProjectPhase::find($material_issue->phase_id);
        return response()->json([
            'project_id' =>$material_issue->project_id,
            'project_name' =>$project->project_name,
            'phase_id' =>$material_issue->phase_id,
            'phase_name' =>$phase->phase_name,
            
        ]);
    }

    public function getitem_list(Request $request)
    {
        $material_list = MaterialIssueList::where('material_issue_id',$request->material_issue_id)->get();
        
        $reg_proj = DB::table('project_regional_warehouse')
        ->where('regional_warehouse_id',$request->regional_id)
        ->get();
        // dd($reg_proj);
        $product_id_arr = [];
        $stock_arr = [];
        $pro_name_arr = [];
        $reg_proj_arr = [];
        $brand = [];
        foreach($reg_proj as $project_id){
            array_push($reg_proj_arr,$project_id->project_id);
        }
      
        
        
        foreach($material_list as $matlist)
        {
            array_push($product_id_arr,$matlist->product_id);
            array_push($stock_arr,$matlist->stock_qty);
            array_push($pro_name_arr,$matlist->product->name);
            array_push($brand,$matlist->product->brand->name);
            
        }
        // dd($stock_arr);
        if(!$reg_proj->isEmpty())
        {
            // dd("hello");
            return response()->json([
                'product_id' => $product_id_arr,
                'stock_qty' => $stock_arr,
                'product_name' => $pro_name_arr,
                'reg_project_id' => $reg_proj_arr,
                'brand' => $brand,
            ]);
        }
        else
        {
            // dd("gello");
            return response()->json([
                'product_id' => $product_id_arr,
                'stock_qty' => $stock_arr,
                'product_name' => $pro_name_arr,
                'reg_project_id' => 0,
            ]);
        }
        

    }

    public function sendWarehouseTransfer(Request $requesst,$material_issue_id){

    	$material_issue = MaterialIssue::find($material_issue_id);

    	$material_issue_lists = MaterialIssueList::where('material_issue_id',$material_issue->id)->get();

        $regional_warehouses = RegionalWarehouse::all();

    	return view('Warehouse/MaterialIssue/send_warehouse_transfer',compact('material_issue','material_issue_lists','regional_warehouses'));
    }

    public function storeWarehouseTransfer(Request $request){
        
        $regional_warehouse_id = $request->regional_warehouse_id;

        $material_issue = MaterialIssue::find($request->material_issue_id);

        $material_issue->regional_warehouse_id = $request->regional_warehouse_id;
        $material_issue->save();

        foreach ($request->transfer_lists as $key => $value) {

            foreach (json_decode($value) as $transfer_list) {

                $product = Product::find($transfer_list->product_id);

                if ($product->id == $transfer_list->product_id) {
                    
                    $product->stock_qty -= $transfer_list->stock_qty;
                    $product->reserved_qty += $transfer_list->stock_qty;
                    $product->save();

                }
                 
            }

        }

        return redirect()->route('material_issue');
    }


    public function send_delivery_order(Request $requesst,$material_issue_id){

        $material_issue = MaterialIssue::find($material_issue_id);

        $material_issue_lists = MaterialIssueList::where('material_issue_id',$material_issue->id)->get();

        $regional_warehouses = RegionalWarehouse::all();

        return view('Warehouse/MaterialIssue/send_delivery_order',compact('material_issue','material_issue_lists','regional_warehouses'));
    }

    public function store_delivery_order(Request $request){
        
    	$validator = Validator::make($request->all(), [
			'delivery_date' => 'required',
			'location' => 'required',
		]);

		if ($validator->fails()) {
			alert()->info("Delivery Date or Location is Required");
			return redirect()->back();
		}

        $material_issue = MaterialIssue::find($request->material_issue_id);

    	$phase = ProjectPhase::find($material_issue->phase_id);

    	$delivery_order = DeliveryOrder::create([
    		'purchase_order_id' => $material_issue->purchase_order_id,
    		'material_issue_id' => $material_issue->id,
			'project_id' => $material_issue->project_id,
			'phase_id' => $material_issue->phase_id,
			'item_list' => json_encode($material_issue->item_list),
			'delivery_date' => $request->delivery_date,
			'location' => $request->location,
			'user_id' => $phase->user_id,
            'approve' => 0,
			'status' => 0,
    	]);
    	
    	$order_num = "DO-" . $today . sprintf("%04s", $purchase_order->id);

		$delivery_order->do_no = $order_num;
		$delivery_order->save();

    	foreach ($delivery_order->item_list as $item_list) {
    		
		DeliveryOrderList::create([
			'delivery_order_id' => $delivery_order->id,
			'product_id' => $item_list->id,
			'stock_qty' => $item_list->qty,
		]);

    }

    foreach ($request->transfer_lists as $key => $value) {

        foreach (json_decode($value) as $transfer_list) {

            $regional_inventory = RegionalInventory::where('product_id',$transfer_list->product_id)
                    ->where('regional_warehouse_id', $material_issue->regional_warehouse_id)
                    ->first();
            
            if ($regional_inventory->product_id == $transfer_list->product_id) {
                
                $regional_inventory->transfer_qty -= $transfer_list->stock_qty;
                $regional_inventory->reserved_qty += $transfer_list->stock_qty;
                $regional_inventory->save();

            }
             
        }

    }

    $material_issue->delivery_order_status = 1;
    $material_issue->save();

    alert()->success('Successfully Sent Delivery Order');
    return redirect()->route('WarehouseTransferOrder');
}

public function check_order_date(Request $request)
{
    // dd($request->ware_transfer_date);
    // dd($request->wto_list);
    $mreq_date_arr = [];
    $porder_date_arr = [];
    $date_arr = [];
    foreach($request->matis_idarr as $eachmatis_id)
    {
        $checkmis = MaterialIssue::find($eachmatis_id);
        // dd($checkmis);
        
        if($checkmis->purchase_order_id == null)
        {
            $material_request_date = MaterialRequest::find($checkmis->material_request_id);
            array_push($mreq_date_arr,$material_request_date->request_date);
        }
        else
        {
            $purchase_order_date = PurchaseOrder::find($checkmis->purchase_order_id);
            
            array_push($porder_date_arr,$purchase_order_date->request_date);
        }
    }
    
    $result = array_merge($mreq_date_arr,$porder_date_arr);
    array_push($date_arr,$result);
    // dd($date_arr[0][1]);
    // Begin Check Date

    for ($i = 0; $i < count($date_arr); $i++)
    {
        if ($i == 0)
        {
            $max_date = date('Y-m-d', strtotime($date_arr[0][$i]));
            $min_date = date('Y-m-d', strtotime($date_arr[0][$i]));
        }
        else if ($i != 0)
        {
            $new_date = date('Y-m-d', strtotime($date_arr[0][$i]));
            if ($new_date > $max_date)
            {
                $max_date = $new_date;
            }
            else if ($new_date < $min_date)
            {
                $min_date = $new_date;
            }
        }
    }
    $mi_date = \Carbon\Carbon::parse($min_date);
    $wtondate = \Carbon\Carbon::parse($request->ware_transfer_date);
   
    $resultwto = $wtondate->diffInDays($mi_date, false);
    // dd($resultwto);
    if($resultwto < 0)
    {
        // dd("error");
        return response()->json([
            'check' => "error",
            'late' => $resultwto * -1,

        ]);
    }
    else
    {
        // dd("success");
        return response()->json([
            'check' => "success",
            
        ]);
    }


    // End Check Date
}

public function getprojects_regional(Request $request)
{
    $regional = RegionalWarehouse::find($request->regional_id);
    $project_reg = DB::table('project_regional_warehouse')
    ->where('regional_warehouse_id',$regional->id)
    ->get();
    // dd($project_reg);
    $projectnamearr = [];
    foreach($project_reg as $project)
    {
        $projects = Project::find($project->project_id);
        array_push($projectnamearr,$projects->project_name);
    }
    // dd($projectnamearr);
    if($projectnamearr == null)
    {
        return response()->json("not"); 
    }
    else
    {
    return response()->json($projectnamearr);
    }
}

}
