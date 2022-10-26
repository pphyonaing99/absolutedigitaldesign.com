<?php

namespace App\Http\Controllers;
// use App\Auth;
use App\MaterialIssue;
use App\User;
use App\MaterialIssueList;
use App\MaterialRequest;
use App\PurchaseOrder;
use App\WarehoueTransferOrder;
use App\Wto_MaterialIssue;
use App\RegionalWarehouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WarehouseTransferOrderController extends Controller
{
    //
    public function show_wto_list()
    {
        
        // $user_id = session()->get('user')->id;
        // $loginuser_project_id = User::find($user_id);
        $wto_list = WarehoueTransferOrder::all();
        $regional = RegionalWarehouse::all();
        $material_issue = MaterialIssue::all();
        // dd($material_issue);
        $mi_wto = Wto_MaterialIssue::all();
        $pur_order = PurchaseOrder::all();
        $material_issue_list = MaterialIssueList::all();
        return view('Warehouse/WarehouseTransferOrder/ware_transfer_order_list',compact('material_issue_list','pur_order','mi_wto','material_issue','wto_list','regional'));
    }
    public function show_wto_list_reg()
    {

        $user_id = session()->get('user')->id;
        // dd($user_id);
        $loginuser_reg_id = User::find($user_id);
        // dd($loginuser_reg_id->regional_id);
        $wto_list = WarehoueTransferOrder::where('wto_regional_id',$loginuser_reg_id->regional_id)->get();
        $regional = RegionalWarehouse::where('id',$loginuser_reg_id->regional_id)->get();
        $material_issue = MaterialIssue::all();
        // dd($wto_list);
        $mi_wto = Wto_MaterialIssue::all();
        $pur_order = PurchaseOrder::all();
        $material_issue_list = MaterialIssueList::all();
        $material_request = MaterialRequest::all();
        return view('Warehouse/WarehouseTransferOrder/ware_transfer_order_reg',compact('material_request','material_issue_list','pur_order','mi_wto','material_issue','wto_list','regional'));
    }
    public function accept_wto_regional($wto_id)
    {
        // dd($wto_id);
        $change_status = WarehoueTransferOrder::find($wto_id);
        $change_status->accept_status = 1;
        $change_status->save();
        $material_issue_status = Wto_MaterialIssue::where('warehouse_transfer_order_id',$wto_id)->get();
        foreach($material_issue_status as $mat_wto)
        {
            $change_matissue_status = MaterialIssue::find($mat_wto->material_issue_id);
            $change_matissue_status->status = 1;
            $change_matissue_status->save();
        }
        return redirect()->back();
    }
    public function createwtono(Request $request)
    {
        // dd($request->digit);
        
        $warehouse_t_o = WarehoueTransferOrder::create([
            'total_qty' => 0,
        ]);

        
        $wto_no = sprintf("%0".$request->digit."s", $warehouse_t_o->id);
        
        $warehouse_t_o->warehouse_transfer_no =  $wto_no;
        $warehouse_t_o->prefix_syntax = $request->syntax;
        $warehouse_t_o->index_digit = $request->digit;
        $warehouse_t_o->save();

        return response()->json([
            'wto_id' => $warehouse_t_o->id,
            'wto_no' => $warehouse_t_o->warehouse_transfer_no,
        ]);
    }
    public function storewaretranorder(Request $request)
    {
        // dd($request->all());
        $ware_transfer = WarehoueTransferOrder::find($request->wto_ID);
        $ware_transfer->date = $request->date;
        $ware_transfer->wto_regional_id = $request->regional_warehouse_id;
        $ware_transfer->total_qty = $request->total_qty;
        $ware_transfer->save();
        // dd($ware_transfer->id);
        foreach($request->mat_ID as $eachmat)
        {

            $warehouse_t_o = Wto_MaterialIssue::create([
                'warehouse_transfer_order_id' => $ware_transfer->id,
                'material_issue_id' => $eachmat,
            ]);
            $wto_status = MaterialIssue::find($eachmat);
            $wto_status->warehouse_transfer_status = 1;
            $wto_status->save();
        }

       

        return back();

    }
}
