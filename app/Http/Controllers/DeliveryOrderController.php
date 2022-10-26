<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryOrder;
use App\DeliveryOrderList;
use App\MaterialIssue;
use App\MaterialIssueList;
use App\MaterialRequest;
use App\WarehoueTransferOrder;
use App\Wto_MaterialIssue;
use App\PurchaseOrder;
use App\RejectItem;

class DeliveryOrderController extends Controller
{
    public function site_delivery_order(){

    	$site_delivery_orders = DeliveryOrder::all();
    	$delivery_order_lists = DeliveryOrderList::all();

    	return view('Manager/DeliveryOrder/delivery_order_list',compact('site_delivery_orders','delivery_order_lists'));

    }
	public function store_reg_site_delivery_order($wto_id)
	{
		// dd($wto_id);
		$ware_t_order = WarehoueTransferOrder::find($wto_id);
		$ware_t_order->deliver_status = 1;
		$ware_t_order->save();
		$ware_t_orlist = Wto_MaterialIssue::where('warehouse_transfer_order_id',$ware_t_order->id)->get();
		foreach($ware_t_orlist as $delistatus)
		{
			$material_issue = MaterialIssue::find($delistatus->material_issue_id);
			$material_issue->delivery_order_status = 1;
			$material_issue->save();
		}
		// dd($ware_t_orlist);
		foreach($ware_t_orlist as $matis)
		{
			$material_issue = MaterialIssue::find($matis->material_issue_id);
			$material_issue->delivery_order_status = 1;
			$material_issue->save();
			if($material_issue->purchase_order_id == null)
			{
				$mrcode = MaterialRequest::find($material_issue->material_request_id);
				$code = $mrcode->id;
				$Deliver_order = DeliveryOrder::create([
					'material_request_id' => $code,
					'material_issue_id' => $matis->material_issue_id,
					'ware_transfer_order_id' => $wto_id,
					'project_id' => $material_issue->project_id,
					'phase_id' => $material_issue->phase_id,
					'item_list' => json_encode($material_issue->item_list),
				]);
			}
			else
			{
				$code = $material_issue->purchase_order_id;
				$Deliver_order = DeliveryOrder::create([
					'purchase_order_id' => $code,
					'material_issue_id' => $matis->material_issue_id,
					'ware_transfer_order_id' => $wto_id,
					'project_id' => $material_issue->project_id,
					'phase_id' => $material_issue->phase_id,
					'item_list' => json_encode($material_issue->item_list),
				]);
			}
			
			$do_no = "DO-".sprintf("%04s",$Deliver_order->id);
       		 
			$Deliver_order->do_no = $do_no;
			$Deliver_order->save();
			$material_issue_list = MaterialIssueList::where('material_issue_id',$matis->material_issue_id)->get();
			foreach($material_issue_list as $matis_pro)
			{
				$Deliver_order_list = DeliveryOrderList::create([
					'delivery_order_id' => $Deliver_order->id,
					'product_id' => $matis_pro->product_id,
					'stock_qty' => $matis_pro->stock_qty,
					
				]);
			}
			

		}
		$ware_t_order->deliver_status = 1;
		$ware_t_order->save();
		return redirect()->back();
		

	}
	public function approve_reg_site_delivery_order($do_id)
	{

		// dd($do_id);
		$change_deli_status = DeliveryOrder::find($do_id);
		$change_deli_status->status = 1;
		$change_deli_status->save();
		alert()->success('Successfully Approved!');
		return back();
	}
	public function update_customer_site_do(Request $request)
	{
		// dd($request->all());
		$delivery_order = DeliveryOrder::find($request->DOid);
		$delivery_order->receive_person = $request->receive_person;
		$delivery_order->phone = $request->phone;
		$delivery_order->location = $request->location;
		$delivery_order->delivery_date = $request->deliver_date;
		$delivery_order->save();
		alert()->success('Successfully Added!');
		return redirect()->back();
	}
	public function minus_do_list_eachproduct(Request $request)
	{
		// dd($request->do_list_id);
		$deliver_order_list = DeliveryOrderList::where('id',$request->do_list_id)->where('product_id',$request->product_id)->first();
		$deliver_order_list->stock_qty = $deliver_order_list->stock_qty - 1;
		if($deliver_order_list->stock_qty <= 0)
		{
			$deliver_order_list->reject_status = 1;
			$deliver_order_list->save();
		}
		if($deliver_order_list->stock_qty < 0)
		{
			$minuserror = 1;
			$deliver_order_list->stock_qty = 0;
			$deliver_order_list->save();
		// dd($deliver_order_list->stock_qty);
		return response()->json([
			'minuserror' => $minuserror,
			'product_id' => $deliver_order_list->product_id,
			'stock' => $deliver_order_list->stock_qty,
		]);
		}
		else
		{
			$minuserror = 0;
			$deliver_order_list->save();
			// dd($deliver_order_list->stock_qty);
			return response()->json([
				'minuserror' => $minuserror,
				'product_id' => $deliver_order_list->product_id,
				'stock' => $deliver_order_list->stock_qty,
			]);
		}
		
	}
	public function check_delivery_date(Request $request)
	{
			// dd($request->do_id);
			$deliver_order_table = DeliveryOrder::find($request->do_id);
			$material_issue = MaterialIssue::find($deliver_order_table->material_issue_id);
			$wto_date = WarehoueTransferOrder::find($deliver_order_table->ware_transfer_order_id);
			$checkindate = [];
			// dd($material_issue);
			if($material_issue->purchase_order_id != null)
			{
				$purchase_order_date = PurchaseOrder::find($material_issue->purchase_order_id);
				$checkdate = $purchase_order_date->request_date;
			}
			else
			{
				$material_request_date = MaterialRequest::find($material_issue->material_request_id);
				// dd($material_request_date);
				$checkdate = $material_request_date->request_date;
			}
			// dd($checkindate);
			$mi_date = \Carbon\Carbon::parse($checkdate);
			$deliver_date = \Carbon\Carbon::parse($request->deliver_date);
			$wto_checkdate = \Carbon\Carbon::parse($wto_date->date);
			$resultmidel = $deliver_date->diffInDays($mi_date, false);
			$resultwtodel = $deliver_date->diffInDays($wto_checkdate, false);
			// dd($resultmidel);
			if($resultmidel > 0 && $resultwtodel < 0)
			{
				// dd("success");
				return response()->json([
					'checked' => "success",
				]);
			}
			else
			{
				// dd("error");
				return response()->json([
					'diffmi' => $resultmidel * -1,
					'diffwto' => $resultwtodel * -1,
					'checked' => "error",
				]);
			}
		

	}
	public function reduce_do_rejectstock(Request $request)
	{
		// dd($request->all());
		$do_list_id_array = json_decode($request->rej_do_list_id);
		$do_product_id_array = json_decode($request->rej_product_id);
		$do_reject_stock_array = json_decode($request->rej_stock_qty);
			for($i=0;$i<count($do_list_id_array);$i++)
			{
				$deliver_order_list = DeliveryOrderList::find($do_list_id_array[$i]);
				$deliver_order_list->stock_qty = $deliver_order_list->stock_qty - $do_reject_stock_array[$i];
				$deliver_order_list->reject_qty = $deliver_order_list->reject_qty + $do_reject_stock_array[$i];
				$deliver_order_list->save();
				//Save in reject item table
				$reject_produt = RejectItem::create([
					'do_id' =>  $request->do_ID,
					'product_id' => $do_product_id_array[$i],
					'do_list_id' => $do_list_id_array[$i],
					
					'regional_id' => $request->regional_id,
					'type' => 2,
					'reject_qty' =>  $do_reject_stock_array[$i],
					
					
				]);
		


				//End save
			}

		
			
			alert()->success('Successfully Rejected!');
			return redirect()->back();
		
		
		
		
	}
	public function get_material_issue_date(Request $request)
	{
		// dd($request->do_id);
		$doinfo = DeliveryOrder::find($request->do_id);
		$mi_info = MaterialIssue::find($doinfo->material_issue_id);
		if($mi_info->purchase_order_id == null)
		{
			$mat_req = MaterialRequest::find($mi_info->material_request_id);
			$mi_date = $mat_req->request_date;
		}
		else
		{
			$pr_order = PurchaseOrder::find($mi_info->purchase_order_id);
			$mi_date = $pr_order->request_date;
		}

		return response()->json($mi_date);
	}
}
