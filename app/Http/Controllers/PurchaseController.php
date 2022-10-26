<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\WarehousePurchaseOrder;

use App\Product;
use App\Category;
use App\Project;
use App\ProjectPhase;
use App\WorkSite;
use App\GoodReceiveNote;
use App\OfficerPurchaseOrder;
use App\OfficerPurchaseOrderList;
use App\RegionalInventory;
use App\SiteInventory;
use App\RegionalWarehouse;
use App\RejectProducts;
use App\RejectList;
use App\RejectItem;
use App\DeliveryOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;


class PurchaseController extends Controller
{
    public function goodReceiveForm(request $request){
        
        $purchase_requests = WarehousePurchaseOrder::all();

        $officer_po = OfficerPurchaseOrder::all();

        $officer_po_list = OfficerPurchaseOrderList::all();
        
        $products = Product::all();
        
        $categories = Category::all();
        
        $projects = Project::all();
        
        $project_phases = ProjectPhase::all();
        
        $work_sites = WorkSite::all();

        $regionalname = RegionalWarehouse::all();

        $goodrn = GoodReceiveNote::all();
        foreach($goodrn as $prefix)
        {
            $prefixgrn = $prefix->prefix_syntax;
            $index = $prefix->index_digit;
        }
        $digit = "";
        for($i = 1;$i<=$prefix->index_digit;$i++)
		{
			$digit .= "0";
		}
        
        return view('ProcurementOfficer/GoodReceiveNoteForm/good_receive_note', compact('digit','index','prefixgrn','officer_po_list','officer_po','regionalname','purchase_requests','products','categories','projects','project_phases','work_sites'));
    }

    public function grn_supervisor_list()
    {
        $good_receive_notes = GoodReceiveNote::where('status',0)->get();
        return view('Warehouse/good_receive_note_list', compact('good_receive_notes'));
    }

    public function rejectList(){
        // dd("Reject");
        // $good_receive_notes_reject = RejectProducts::all();
        $good_receive_notes_reject = RejectItem::all();
        $grn_list = GoodReceiveNote::all();
        $deliver_order = DeliveryOrder::all();
       
        // return view('ProcurementOfficer/Reject/reject_list',compact('good_receive_notes_reject'));
        return view('ProcurementOfficer/Reject/reject_list_new',compact('deliver_order','grn_list','good_receive_notes_reject'));
    }

    public function approve_reject_itemfromreg(Request $request)
    {
        // dd($request->reject_id);
        $reject_table = RejectItem::find($request->reject_id);
        $reject_table->status = 1;
        $reject_table->save();
        // $grn_product_table = DB::table('good_receive_note_product')->where('id',$reject_table->grn_product_id)->first();
        $affected = DB::table('good_receive_note_product')
                     ->where('id',$reject_table->grn_product_id)
                        ->update(['change_status' => 3]);
      

        return response()->json("success");


    }
    public function accept_grnproduct_reg(Request $request)
    {
        // dd($request->all());
        $affected = DB::table('good_receive_note_product')
        ->where('id',$request->grn_pivotpro_id)
           ->update(['change_status' => 4]);
        $grn_product_table = DB::table('good_receive_note_product')
        ->where('id',$request->grn_pivotpro_id)
        ->first();
        
                            
        $regional_warehouse = RegionalInventory::where('regional_warehouse_id',$request->regional_id)->where('product_id',$grn_product_table->product_id)->first();
        // dd($regional_warehouse);
        $product_detail = Product::find($grn_product_table->product_id);
        if($regional_warehouse == null)
        {
            $addProduct = RegionalInventory::create([
                'product_id' =>  $grn_product_table->product_id,
                'regional_warehouse_id' => $request->regional_id,
                'model_number' => $product_detail->model_number,
                'measuring_unit' => $product_detail->measuring_unit,
                'name' => $product_detail->name,
                'transfer_qty' => $grn_product_table->quantity,
                'reserved_qty' =>  $product_detail->reserved_qty,
                'location' => $product_detail->location,
            ]);
        }
        else
        {
        $regional_warehouse->transfer_qty +=$grn_product_table->quantity;
        $regional_warehouse->save();
        }
        return response()->json("success");
    }
    public function accept_grnproduct_main(Request $request)
    {
        // dd($request->all());
        $affected = DB::table('good_receive_note_product')
        ->where('id',$request->grn_pivotpro_id)
           ->update(['change_status' => 4]);
           $grn_product_table = DB::table('good_receive_note_product')
        ->where('id',$request->grn_pivotpro_id)
        ->first();
        $product_detail = Product::find($grn_product_table->product_id);
        $product_detail->stock_qty +=$grn_product_table->quantity;
        $product_detail->save();
        return response()->json("success");

    }
    public function delete_grnproduct_reg(Request $request,$grn_pivotpro_id)
    {
        $grn_product_table =  DB::table('good_receive_note_product')->where('id',$grn_pivotpro_id)->first();
        DB::table('good_receive_note_product')->where('id',$grn_pivotpro_id)->delete();
        
        $grn_product =  DB::table('good_receive_note_product')->where('good_receive_note_id',$grn_product_table->good_receive_note_id)->get();
        // dd(count($grn_product));
        if(count($grn_product) == 0)
        {
            // dd("all empty");
            $good_receive_note_delete = GoodReceiveNote::where('id',$grn_product_table->good_receive_note_id)->delete();
            alert()->success('All Products are Empty!');
            return redirect()->route('good_receive_note_list');
        }
        else
        {
            alert()->success('Successfully Deleted!');
            return redirect()->back();
        }
        
        
    }
    public function delete_grnproduct_main(Request $request,$grn_pivotpro_id)
    {
        $grn_product_table =  DB::table('good_receive_note_product')->where('id',$grn_pivotpro_id)->first();
        DB::table('good_receive_note_product')->where('id',$grn_pivotpro_id)->delete();
        
        $grn_product =  DB::table('good_receive_note_product')->where('good_receive_note_id',$grn_product_table->good_receive_note_id)->get();
        // dd(count($grn_product));
        if(count($grn_product) == 0)
        {
            // dd("all empty");
            $good_receive_note_delete = GoodReceiveNote::where('id',$grn_product_table->good_receive_note_id)->delete();
            alert()->success('All Products are Empty!');
            return redirect()->route('good_receive_note_list_normal');
        }
        else
        {
            alert()->success('Successfully Deleted!');
            return redirect()->back();
        }

    }
    
    public function goodReceiveNoteList(request $request){
        
        $good_receive_notes = GoodReceiveNote::where('status',0)->get();
        // dd($good_receive_notes);
        return view('Manager/Procurement/good_receive_note_list', compact('good_receive_notes'));
    }
    
    public function goodReceiveNoteDetails($good_receive_note_id){
        // dd($good_receive_note_id);
        $good_receive_note = GoodReceiveNote::find($good_receive_note_id);
        //  dd($good_receive_note);
        $regID = 1;
        return view('Manager/Procurement/approve_grn_formain', compact('regID','good_receive_note'));
    }

    public function ajaxgrnapprove(Request $request)
    {
        // dd($request->grn_id);
        $good_receive_note = GoodReceiveNote::find($request->grn_id);
        //  dd($good_receive_note);
        $good_receive_note->approve_status = 1;
        $good_receive_note->save();
        return response()->json('success');
    }
    // public function goodReceiveNoteApprove($good_receive_note_id){
    //     // dd($good_receive_note_id);
    //     $good_receive_note = GoodReceiveNote::find($good_receive_note_id);
    //     //  dd($good_receive_note);
    //     $good_receive_note->approve_status = 1;
    //     $good_receive_note->save();
    //     return view('ProcurementOfficer/GoodReceiveNoteForm/good_receive_note_list', compact('good_receive_note'));
    // }

    public function goodReceiveNoteDetailsRegional(Request $request){
        //  dd($request->all());
        // dd("hellore");
        $good_receive_note = GoodReceiveNote::find($request->gid);
        $regionalWID = RegionalWarehouse::find($request->regionalID);
        $regID = $regionalWID->id;
        $regname = $regionalWID->warehouse_name;
        // dd("Done");
        return view('Manager/Procurement/good_receive_note_details', compact('good_receive_note','regID','regname'));
    }

    public function update_each_item_des(Request $request)
    {
        // return response()->json("success");
        // dd($request->all());
        // dd($request->pro_id);
       
        $purlist = OfficerPurchaseOrderList::where('id',$request->po_id)->where('product_id',$request->pro_id)->first();
        $purchase_req = WarehousePurchaseOrder::where('id',$purlist->purchase_request_id)->first();
        // dd($purlist);
        if($request->reg_id == null && $request->proj_id == null)
        {
            // dd("main");
            $purlist->warehouse_flag = 1;
            $purlist->regional_id = null;
            $purlist->regional_name = null;
            $purlist->project_id = null;
            $purlist->phase_id = null;
            $purlist->site_id = null;
            $purlist->save(); 
            $purchase_req->destination_flag = 1;
            $purchase_req->destination_regional_id = null;
            $purchase_req->regional_name = null;
            $purchase_req->project_id = null;
            $purchase_req->phase_id = null;
            $purchase_req->save();
            // dd("main end");
            return response()->json("main");
        }
        elseif($request->main == null && $request->proj_id == null)
        {
            // dd("regional");
            $regional_id = $request->reg_id;
            $regname = RegionalWarehouse::find($request->reg_id);

            // dd($purlist->regional_id);
            $purlist->regional_id = $request->reg_id;
            $purlist->regional_name = $regname->warehouse_name;
            $purlist->warehouse_flag = 2;
            $purlist->project_id = null;
            $purlist->phase_id = null;
            $purlist->site_id = null;
            $purlist->save();
            $purchase_req->destination_flag = 2;
            $purchase_req->destination_regional_id = $request->reg_id;
            $purchase_req->regional_name = $regname->warehouse_name;
            $purchase_req->project_id = null;
            $purchase_req->phase_id = null;
            $purchase_req->save();
            // dd("regional end");
            return response()->json([
                'isregional' => "regional",
                'regional_id' => $request->reg_id,
                'regional_name' =>  $regname->warehouse_name, 
            ]);
            //example
            // return response()->json([
            //     'supplier_name' => $supplier_name,
            //     'purchase_order' => $purchase_order,
            //     'supplier_email' => $purchase_order->supplier->email,
            //     'brands' => $brands,
            //     'products' => $products,
            // ]);
            //end example
        }
        elseif($request->reg_id == null && $request->main == null)
        {
            // dd("site");
            $purlist->project_id = $request->proj_id;
            $purlist->phase_id = $request->phase_id;
            $purlist->site_id = $request->site_id;
            $purlist->warehouse_flag = null;
            $purlist->regional_id = null;
            $purlist->regional_name = null;
            $purlist->save();
            $purchase_req->destination_flag = null;
            $purchase_req->destination_regional_id = null;
            $purchase_req->regional_name = null;
            $purchase_req->project_id = $request->proj_id;
            $purchase_req->phase_id = $request->phase_id;
            $purchase_req->save();
            $project_name = Project::find($request->proj_id);
            $phase_name = ProjectPhase::find($request->phase_id);
            $site_name = WorkSite::find($request->site_id);
            // dd("site end");
            return response()->json([
                'issite' => "site",
                'project_id' => $request->proj_id,
                'phase_id' => $request->phase_id,
                'site_id' => $request->site_id,
                'project_name' => $project_name->project_name,
                'phase_name' => $phase_name->phase_name,
                'site_name' => $site_name->name,
            ]);
        }
        else
        {
            dd("idiot");
        }
        


        
         
    }
    public function show_grn_lists()
    {
        // dd("hello");
        $good_receive_notes = GoodReceiveNote::where('status',0)->get();
        $good_reg = DB::table('good_receive_note_regional_warehouse')->get();
        $reg_name = RegionalWarehouse::all();
        // dd($good_reg);
        return view('ProcurementOfficer/GoodReceiveNoteForm/good_receive_note_list', compact('reg_name','good_receive_notes','good_reg'));
    }
    // public function check_grn_date_prpo(Request $request)
    // {
    //     dd($request->all());
    // }


    public function storeGoodReceiveNote(request $request){
        // dd($request->all());
        dd($request->poID);
        
        $grn_date = $request->date;
       $decision = $request->deci;
       // $pros = json_decode($request->parr);
       $product_id = $request->products;
       $quantity = $request->po_id;
       $product_name = $request->pro_name;
       $supplier_name = $request->sup_name;
       $pur_price = $request->pur_price;
    //    $cate_id = $request->cate_id;
     
       $main = $request->testingmain;
       $regional_id = $request->testingreg;
       $project_id = $request->testingsiteproj;
       $phase_id = $request->testingsitephase;
       $site_id = $request->testingsiteEnge;
       $total_qty = $request->total_qty;
       $de0_main = $request->de0_main;
       $de0_regional_id = $request->de0_reg_id;
       $de0_project_id = $request->de0_proj_id;
       $de0_phase_id = $request->de0_phase_id;
       // $de0_site_id = $request->
// $cats = [];
//        foreach($cate_id as $cate)
//        {
//        $cate_name = Category::find($cate);
//        array_push($cats,$cate_name->name);
//        }
    //    dd($cats);

    //Purchase Order change grn sent status
    


    //End Purchase Order change status
    $poidarray = [];
        foreach($request->poID as $poids)
        {
            $p_orderlist_id = OfficerPurchaseOrderList::find($poids);
            $p_order_id = OfficerPurchaseOrder::find($p_orderlist_id->officer_purchase_order_id);
            array_push($poidarray,$p_order_id->id);
        }
    $podatearrr = [];
    foreach($poidarray as $eachpoid)
    {
        $po_date_db = OfficerPurchaseOrder::find($eachpoid);
        array_push($podatearrr,$po_date_db->po_date);
    }
    // dd($podatearrr);
    $pridarray = [];
    foreach($request->poID as $findprid)
    {
        $pr_id = OfficerPurchaseOrderList::find($findprid);
        array_push($pridarray,$pr_id->purchase_request_id);
    }
    // dd($pridarray);
    $prdatearrr = [];
    foreach($pridarray as $prids)
    {
        $pr_date_db = WarehousePurchaseOrder::find($prids);
        dd($pr_date_db);
        array_push($prdatearrr,$pr_date_db->required_date);
    }

    // check date with po date
    for ($i = 0; $i < count($podatearrr); $i++)
    {
        if ($i == 0)
        {
            $max_date = date('Y-m-d', strtotime($podatearrr[$i]));
            $min_date = date('Y-m-d', strtotime($podatearrr[$i]));
        }
        else if ($i != 0)
        {
            $new_date = date('Y-m-d', strtotime($podatearrr[$i]));
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
    $po_date = \Carbon\Carbon::parse($min_date);
    $grndate = \Carbon\Carbon::parse($request->date);
   
    $resultpo = $grndate->diffInDays($po_date, false);
    // end check date po
    // Check date with pr 
    for ($i = 0; $i < count($prdatearrr); $i++)
    {
        if ($i == 0)
        {
            $maxr_date = date('Y-m-d', strtotime($prdatearrr[$i]));
            $minr_date = date('Y-m-d', strtotime($prdatearrr[$i]));
        }
        else if ($i != 0)
        {
            $newr_date = date('Y-m-d', strtotime($prdatearrr[$i]));
            if ($new_date > $maxr_date)
            {
                $maxr_date = $new_date;
            }
            else if ($new_date < $minr_date)
            {
                $minr_date = $newr_date;
            }
        }
    }
    $pr_date = \Carbon\Carbon::parse($minr_date);
    $grndate = \Carbon\Carbon::parse($request->date);
   
    $resultpr = $grndate->diffInDays($pr_date, false);

    // end check date pr
    if($resultpo <= 0 && $resultpr >= 0)
    {
        // dd("ok");
        $array = [];
        foreach($request->poID as $polist_id)
        {
            $po_grn_status = OfficerPurchaseOrderList::find($polist_id);
            
                $po_grn_status->grn_sent_status = 1;
                $po_grn_status->save();
            $p_order_id = OfficerPurchaseOrderList::where('id',$polist_id)->where('grn_sent_status',0)->first();
          
            if($p_order_id == null && $po_grn_status->officer_purchase_order_id != null)
            {
                $po_real = OfficerPurchaseOrder::where('id',$po_grn_status->officer_purchase_order_id)->delete();
            
            }

           
            
          
            
            
            // if($p_order_id == null)
            // {
            //     $po_delete = OfficerPurchaseOrder::find($p_order_id->officer_purchase_order_id);
            //     $po_delete->delete();
            // }

            
            
            

          
            
           
            
        }

        // foreach($p_order_id as $po_real_id)
        // {
        //     dd("delete");
        //     $po_delete = OfficerPurchaseOrder::find($po_real_id->officer_purchaser_order_id);
        //     $po_delete->delete();

        // }
        
        // dd($p_order_id);
        
            // if($deletepo === null)
            // {
            //     $po = OfficerPurchaseOrder::find($po_grn_status->officer_purchase_order_id);
            //     // dd($po);
            //     // $po->delete();
            //     array_push($array,$po->id);

            // }
       
        // dd("ok");
        if($decision == 0)
        {
           
            if($de0_regional_id == null && $de0_project_id == null)
            {
             // dd("d0");
             $warehouse_flag = 1;
             $isregional_id = null;
            }
            elseif($de0_main == null && $de0_regional_id == null)
            {
             
            $project = ProjectPhase::find($de0_project_id);
            $projectName = Project::find($project->id);
         //    dd($project->id);
            $usephase_id = $de0_phase_id;
            $warehouse_flag = null;
            $isregional_id = null;
            }
            elseif($de0_main == null && $de0_project_id == null)
            {
             // dd("d2");
             $warehouse_flag = 2;
             $regional = RegionalWarehouse::find($de0_regional_id);
             $isregional_id = $regional->id;
 
            }
        }
        elseif($decision == 1)
        {
         
             if($regional_id == null && $project_id == null)
             {
                 // dd("d1");
                 $warehouse_flag = 1;
                 $isregional_id = null;
             }
             elseif($main == null && $regional_id==null)
             {
                 $project = ProjectPhase::find($project_id);
                 $projectName = Project::find($project->id);
                 $usephase_id = $phase_id;
                 $warehouse_flag = null;
                 $isregional_id = null;
             }
             elseif($main == null && $project_id == null)
             {
                 $warehouse_flag = 2;
                 $regional = RegionalWarehouse::find($regional_id);
                 $isregional_id = $regional->id;
             }
        }
        elseif($decision == 3)
        {
         
             if($regional_id == null && $project_id == null)
             {
                 // dd("d2");
                 $warehouse_flag = 1;
                 $isregional_id = null;
             }
             elseif($main == null && $regional_id==null)
             {
                 $project = ProjectPhase::find($project_id);
                 $projectName = Project::find($project->id);
                 $usephase_id = $phase_id;
                 $warehouse_flag = null;
                 $isregional_id = null;
             }
             elseif($main == null && $project_id == null)
             {
                 $warehouse_flag = 2;
                 $regional = RegionalWarehouse::find($regional_id);
                 $isregional_id = $regional->id;
             }
        }
 
       
     //    dd($warehouse_flag);
       
        // dd($projectName->project_name);
        // $a=$request->qty;
        // $total = array_sum($a);
 
        // dd($total);
     //    $validator = Validator::make($request->all(), [
     //        'grn_no' => 'required',
     //        'date' => 'required',
     //        'pr_no' => 'required',
     //        'product_id' => 'required',
     //        'category' => 'required',
     //        'qty' => 'required',
     //        'supplier' => 'required',
     //        'purchase_price' => 'required',
     //        'type' => 'required',
     //        'remark' => 'required',
            
     //    ]);
 
     //    if ($validator->fails()) {
 
     //        alert()->error('Something Wrong! Validation Error!');
 
     //        return redirect()->back()->withErrors($validator)->withInput();
     //    }
 
        // $regionalID = $request->regid;
        // sprintf("%04s", $purchase_order->id);
        
        $grn_num = $request->grn_prefix ."-" . sprintf("%0".$request->index_digit."s", $request->grn_no);
        
       //$product_id = $request->product_id;old
        // dd($product_id);
     //    $product_detail = [];
     //    foreach($product_id as $prod_id);
     //    {
     //     $product_details = Product::find($prod_id);
     //     array_push($product_detail,$product_details->id); 
     //    }
        
        
     //    dd($product_detail);
 
        // $product_name = $product_detail->name;
        
     //    $category_name = $request->category;old
        
     //    $supplier = $request->supplier;old
        
     //    $purchase_price = $request->purchase_price;old
        
     //    $quantity = $request->qty;old
        
     //    $remark = $request->remark;old
        if($warehouse_flag != null)
        {
         $good_receive_note = GoodReceiveNote::create([
            
             'grn_no' =>  $grn_num,
             'date' => $request->date,
          //    'type' => $request->type,
          'prefix_syntax' => $request->grn_prefix,
          'index_digit' => $request->index_digit,
             'warehouse_flag' => $warehouse_flag,
             'project_phase_id' => $request->phase_id,
          //    'work_site_id' => $request->site_id,
             //  'work_site_id' => null,
             'total_qty' => $total_qty,
             // 'project_name' => null,
             
         ]);
 
        }
        else
        {
         $good_receive_note = GoodReceiveNote::create([
         'grn_no' =>  $grn_num,
         'date' => $request->date,
      //    'type' => $request->type,
         
         'project_phase_id' => $usephase_id,
      //    'work_site_id' => $request->site_id,
          'work_site_id' => $project->id,
         'total_qty' => $total_qty,
         'project_name' => $projectName->project_name,
         ]);
        }
        
 
       //each qty
     //   foreach($products_id as $eachpro_id)
     //   {
     //   foreach($po_id as $eachpo_id)
     //   {
         
         if($warehouse_flag != null){
             for($count = 0; $count < count($product_id); $count++){
  
                 // $good_receive_note->product()->attach($product_id[$count], ['quantity' => $quantity[$count], 'category_name' => $category_name[$count], 'supplier' => $supplier[$count], 'purchase_price' => $purchase_price[$count], 'remark' => $remark[$count]]);
                 $good_receive_note->product()->attach($product_id[$count], ['quantity' => $quantity[$count],'product_name' => $product_name[$count], 'supplier' => $supplier_name[$count], 'purchase_price' => $pur_price[$count], 'remark' => "hello"]);
             }
         }else{
           
             for($count = 0; $count < count($product_id); $count++){
               
                 // $good_receive_note->product()->attach($product_id[$count], ['quantity' => $quantity[$count],'product_name' => $product_detail[$count]->name, 'category_name' => $category_name[$count], 'supplier' => $supplier[$count], 'purchase_price' => $purchase_price[$count], 'remark' => $remark[$count],'status' => 1]);
                 $good_receive_note->product()->attach($product_id[$count], ['quantity' => $quantity[$count],'product_name' => $product_name[$count],'supplier' => $supplier_name[$count], 'purchase_price' =>$pur_price[$count], 'remark' => "hello",'status' => 1]);
             
         }
       }
     // }
     //   }
       //end each qty
       
       
        
        
        
    
        // dd($product_id);
        //   for($count = 0; $count < count($product_id); $count++){
        //     $products = Product::find($product_id[$count]);
        //      $site = SiteInventory::create([
        //         'product_id' => $products->id,'model_number' => $products->model_number,'measuring_unit' => 11, 'name' => $products->name, 'brand_name' => "AAA", 'delivered_qty' => 88, 'location' => "dffdff", 'received_date' => "2020-10-29", 'project_id' => 1, 'phase_id' => 1,'flag' => 1,
        //     ]); 
           
        
            
                
        //   }
        //  dd($products->id);
        
        //CONTINUE
     //    foreach($request->pr_no as $pr_no){
            
     //        $good_receive_note->warehouse_purchase_order()->attach($pr_no);
     //    }
        //END
        
            
         //    $good_receive_note->regional()->attach($request->regid);old
         if($isregional_id != null)
         {
         $good_receive_note->regional()->attach($regional->id);
         }
            // dd($request->all());
         //    if($request->regid == null && $request->warehouse_flag == 2){
             if($isregional_id == null && $warehouse_flag != 1){
                for($count = 0; $count < count($product_id); $count++){
                    $produ = Product::find($product_id[$count]);
                    $projectID = ProjectPhase::find($usephase_id);
                 //    dd($projectID->id);
                    $mn = $produ->model_number;
                    $name = $produ->name;
                    $munit = $produ->measuring_unit;
                    $locat = $produ->location;
                    $projectid = $projectID->project_id;
                    $siteInventory = SiteInventory::create([
                        'product_id' => $product_id[$count],
                        'model_number' => $mn,
                        'measuring_unit' =>$munit,
                        'name' => $name,
                        'brand_name' => "Samsung",
                        'delivered_qty' => $quantity[$count],
                        'location' =>$locat,
                        'project_id'=>$projectid,
                        'phase_id' =>$projectID->id,
                        'flag' => 0,
                        
            
                    ]);
                    
                   }
             }
         //    }
        
        alert()->success('Successfully stored');
        
        return redirect()->back();
    }
    else
    {
        // dd("not ok");
        alert()->success('Good Receive Note Date is invalid!!');
        return redirect()->back();
    }



    
       //old
       // $prod_id = $request->product_id;
       // $qtyy = $request->qty;
       // $phase_id=$request->phase_id;
       // end old

       

      
   
}
    
 
    public function acceptproductMain(Request $request){
    //    dd($request->all());
        $hasProduct = Product::find($request->pid);
        // $GRNote = GoodReceiveNote::find();//for delete good receive note
        $hasProduct->stock_qty += $request->qty;
        $hasProduct->save();
        // $goodpro = DB::table('good_receive_note_product')
        // ->where('good_receive_note_id',$request->gid)
        // ->where('product_id',$request->pid)
        // ->get();
        // foreach($goodpro as $goodp)
        // $goodp->status += 1;
    //     $ggg = GoodReceiveNote::find($request->gid);
    //     foreach($ggg->product() as $prod)
    // dd($prod->id);
             
        
        $goodpro = DB::table('good_receive_note_product')
        ->where('good_receive_note_id',$request->gid)
        ->where('product_id',$request->pid)
        ->delete();
        // dd($goodproduct);
        $GRNdelete = DB::table('good_receive_note_product')
        ->where('good_receive_note_id',$request->gid)
        ->first();
        // dd($GRNdelete);
        if($GRNdelete == null){
            $DeleteGRN = GoodReceiveNote::find($request->gid);
            // dd($DeleteGRN);
            $DeleteGRN->delete();
            $good_receive_notes = GoodReceiveNote::all();
       
            return view('Manager/Procurement/good_receive_note_list',compact('good_receive_notes'));
        }
        

    //    $deletegrn =  GoodReceiveNote::where("id",$request->gid)->get();
    //    dd($deletegrn);
    return redirect()->back();
        
    }
    public function acceptproductRegional(Request $request){
        // dd($request->all());
       
        // dd("hello");
        $hasProduct = RegionalInventory::where('product_id',$request->pid)->where('regional_warehouse_id',$request->rwid)->first();
        
        $hasPr = RegionalInventory::where('product_id',$request->pid)->where('regional_warehouse_id',$request->rwid)->get();
        
        
        $productS = Product::find($request->pid);
        // dd($productS->reserved_qty);
        
        if($hasProduct == null)
        {
            $addProduct = RegionalInventory::create([
            'product_id' =>  $request->pid,
            'regional_warehouse_id' => $request->rwid,
            'model_number' => $productS->model_number,
            'measuring_unit' => $productS->measuring_unit,
            'name' => $productS->name,
            'transfer_qty' => $request->qty,
            'reserved_qty' =>  $productS->reserved_qty,
            'location' => $productS->location,

            ]);
           
        }else{
            foreach($hasPr as $haspro)
            $haspro->transfer_qty += $request->qty;
            $haspro->save();
            
        }
        $goodpro = DB::table('good_receive_note_product')
        ->where('good_receive_note_id',$request->gid)
        ->where('product_id',$request->pid)
        ->delete();
        $GRNdelete = DB::table('good_receive_note_product')
        ->where('good_receive_note_id',$request->gid)
        ->first();
       
        if($GRNdelete == null){
            $DeleteGRN = GoodReceiveNote::find($request->gid);
            // dd($DeleteGRN);
            $DeleteGRN->delete();
            $good_receive_notes = GoodReceiveNote::all();
       
            return view('Manager/Procurement/good_receive_note_list',compact('good_receive_notes'));
        }
        // dd("hello");
        
        return redirect()->back();
    }
    public function postregionalName(Request $request){
        // dd($request->id);
        return response()->json($request->id);

        
    }
    public function rejectWare(Request $request){
        dd($request->all());
        $goodRN = GoodReceiveNote::find($request->grnid);
        // $goodproduct = DB::table('good_receive_note_product')
        // ->where('good_receive_note_id',$request->grnid)
        // ->where('product_id',$request->pid)
        // ->get();
        // foreach($goodproduct as $gpro)
        // dd($gpro->id);
        // dd($request->all());
        $rejectprodut = RejectProducts::create([
            'grn_no' =>  $goodRN->grn_no,
            'product_id' => $request->pid,
            'product_name' =>$request->proname,
            'good_receive_note_id' => $request->grnid,
            'regional_name' => $request->rwn,
            'date' => $goodRN->date,
            'type' => $goodRN->type,
            'warehouse_flag' => $goodRN->warehouse_flag,
            
            'quantity' => $request->qty,
            'category_name' => $request->cat,
            'supplier' => $request->sup,
            'purchase_price' => $request->pur,
            'project_phase_id' => $goodRN->phase_id,
            'work_site_id' => $goodRN->site_id,
            'remark' => $request->rem,
        ]);

        $goodRN->product()->detach($request->pid, ['good_receive_note_id' => $request->gid]);
        // dd($goodRN);
        $GRNdelete = DB::table('good_receive_note_product')
        ->where('good_receive_note_id',$request->grnid)
        ->first();
    //    dd($GRNdelete);
        if($GRNdelete == null){
        
        // dd($goodRN);
        // $goodRN->status = 1;
        // $goodRN->save;
        $goodRN->delete();
        $good_receive_notes = GoodReceiveNote::all();
       
        return view('Manager/Procurement/good_receive_note_list',compact('good_receive_notes'));
        }
        else{
            
            return redirect()->back();
        }
    
      
         
    }
    public function reject_regional_eachproduct(Request $request)
    {
        // dd($request->grn_pivotpro_id);
        $GRNdelete = DB::table('good_receive_note_product')
        ->where('id',$request->grn_pivotpro_id)
        ->first();
        $affected = DB::table('good_receive_note_product')
                     ->where('id',$request->grn_pivotpro_id)
                        ->update(['change_status' => 1]);
        // dd($GRNdelete);
        $grn = GoodReceiveNote::find($GRNdelete->good_receive_note_id);
        // dd($grn);
        // dd($request->regional_id);
        $reject_produt = RejectItem::create([
            'grn_id' =>  $grn->id,
            'product_id' => $GRNdelete->product_id,
            'grn_product_id' =>$request->grn_pivotpro_id,
            'reject_date' => $request->date,
            'regional_id' => $request->regional_id,
            
            'type' => 1,
            
            
            'reject_qty' => $GRNdelete->quantity,
            
            'supplier' => $GRNdelete->supplier,
            
            
            
            'remark' => $request->remark,

            
        ]);

        return response()->json("success");


        

    }
    public function reject_regional_eachproduct_Main(Request $request)
    {
        
        $GRNdelete = DB::table('good_receive_note_product')
        ->where('id',$request->grn_pivotpro_id)
        ->first();
        $affected = DB::table('good_receive_note_product')
                     ->where('id',$request->grn_pivotpro_id)
                        ->update(['change_status' => 1]);
        // dd($GRNdelete);
        $grn = GoodReceiveNote::find($GRNdelete->good_receive_note_id);
        // dd($grn);
        // dd($request->regional_id);
        $reject_produt = RejectItem::create([
            'grn_id' =>  $grn->id,
            'product_id' => $GRNdelete->product_id,
            'grn_product_id' => $request->grn_pivotpro_id,
            'reject_date' => $request->date,
            
            
            'type' => 1,
            
            
            'reject_qty' => $GRNdelete->quantity,
            
            'supplier' => $GRNdelete->supplier,
            
            
            
            'remark' => $request->remark,

            
        ]);

        return response()->json("success");




    }
    public function rejectMain(Request $request){
        // dd($request->all());
        $goodRN = GoodReceiveNote::find($request->gid);
        
        //  dd($goodRN);
        $goodproduct = DB::table('good_receive_note_product')->where('good_receive_note_id',$request->gid)->where('product_id',$request->pid)->get();
        // dd($goodproduct);
        foreach($goodproduct as $good)
        // dd($good->quantity);
        $rejectprodut = RejectProducts::create([
            'grn_no' =>  $goodRN->grn_no,
            'product_id' => $request->pid,
            'product_name' =>$request->proname,
            'good_receive_note_id' => $request->gid,
            'regional_name' => "Main",
            'date' => $goodRN->date,
            'type' => $goodRN->type,
            'warehouse_flag' => $goodRN->warehouse_flag,
            
            'quantity' => $request->qty,
            'category_name' => $request->cat,
            'supplier' => $request->sup,
            'purchase_price' => $good->purchase_price,
            'project_phase_id' => $goodRN->phase_id,
            'work_site_id' => $goodRN->site_id,
            'remark' => $request->rem,
        ]);
        
       
        $goodRN->product()->detach($request->pid, ['good_receive_note_id' => $request->gid]);
        $GRNdelete = DB::table('good_receive_note_product')
        ->where('good_receive_note_id',$request->gid)
        ->first();
    
        if($GRNdelete == null){
        $goodRN->delete();
        // $goodRN->status = 1;
        
        // $goodRN->save();
        
        $good_receive_notes = GoodReceiveNote::all();
       
        return view('Manager/Procurement/good_receive_note_list',compact('good_receive_notes'));
        }
        else{
           
            
            return redirect()->back();
        }
    }
    // public function rejectdetails(Request $request){
    //     // dd($request->all());
    //     $rejectpro = RejectList::where('id',$request->id)->get();
    //     // dd($rejectpro);
       
    //     // dd($prod);
    //     // dd($rejectpro);
    //     return view('ProcurementOfficer/Reject/reject_details', compact('rejectpro'));
    // }
    public function rejectDetailspro(Request $request){
        // dd($request->all());
        $good_receive_note = GoodReceiveNote::find($request->gid);
        // dd($good_receive_note);
        // $regionalWID = RegionalWarehouse::find($request->regionalid);
        // $reggID = $regionalWID->id;
        // $reggname = $regionalWID->warehouse_name;
        // dd("Done");
        return view('ProcurementOfficer/Reject/reject_details', compact('good_receive_note'));
    }

    public function get_master_page()
    {
        return view('master');
    }

 
}
