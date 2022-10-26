<?php

namespace App\Http\Controllers;

use App\MaterialIssue;
use App\Product;
use App\MaterialRequest;
use App\MaterialRequestList;
use Illuminate\Http\Request;
use App\WarehousePurchaseOrderList;

class MaterialRequestController extends Controller
{
	/* ===========================
			Project Manager
	============================== */
    public function material_request_list(){

    	$material_requests = MaterialRequest::orderBy('warehouse_status','asc')->get();

    	$material_request_lists = MaterialRequestList::all();
    	
    	return view('Manager/Material_Request/material_request_list',compact('material_requests','material_request_lists'));
    }

    public function send_material_request(Request $request,$material_request_id){

    	$material_request = MaterialRequest::find($material_request_id);

    	$material_request->remark = $request->remark;
    	$material_request->warehouse_status = 1;
    	$material_request->save();

    	alert()->success("Successfully Sent Material Request To Warehouse");
    	return redirect()->back();

    }
    /* ===========================
		Warehouse Supervisor
	============================== */

	public function warehouse_material_request(){
		$true_request = WarehousePurchaseOrderList::all();
		$material_requests = MaterialRequest::all();
		$material_request_lists = MaterialRequestList::all();
		$products = Product::all();
		$matissue = MaterialIssue::all();
		foreach($matissue as $matissues)
		{
			$prefix = $matissues->prefix_syntax;
			$index = $matissues->index_digit;
			$digit = "";
		for($i = 1;$i<=$matissues->index_digit;$i++)
		{
			$digit .= "0";
		}
		}

		return view('Warehouse/MaterialRequest/material_request_list',compact('index','digit','prefix','true_request','material_requests','material_request_lists','products'));
	}

}
