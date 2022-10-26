<?php

namespace App\Http\Controllers;

use App\MaterialRequest;
use App\Product;
use App\Supplier;
use App\Project;
use App\RegionalWarehouse;
use App\SaleOrder;
use App\SaleOrderList;
use Illuminate\Http\Request;
use App\OfficerPurchaseOrder;
use Illuminate\Support\Carbon;
use App\WarehousePurchaseOrder;
use App\OfficerPurchaseOrderList;
use App\OfficerPurchaseOrderLists;
use Illuminate\Support\Facades\DB;
use App\WarehousePurchaseOrderList;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PurchaseRequestController extends Controller
{
    public function purchase_request_list(){

    	$purchase_orders = OfficerPurchaseOrder::orderBy('id','desc')->get();

    	$purchase_request_lists = WarehousePurchaseOrderList::all();

    	$products = Product::all();

    	$suppliers = Supplier::all();

        $brand_supplier = DB::table('brand_supplier')->get();
dd($brand_supplier);
    	return view('Warehouse/PurchaseRequest/purchase_request_list',compact('brand_supplier','purchase_orders','purchase_request_lists','products','suppliers'));

    }
    
    public function warehousePurchaseRequest(){

    	$purchase_orders = WarehousePurchaseOrder::orderBy('id','desc')->get();

        $material_request = MaterialRequest::all();

    	$purchase_request_lists = WarehousePurchaseOrderList::all();

    	$products = Product::all();

    	$suppliers = Supplier::all();

        $project = Project::all();

        $regional = RegionalWarehouse::all();

        $sale_order = SaleOrder::all();

        $sale_order_list = SaleOrderList::all();
// dd("hello");
    	return view('Warehouse/PurchaseRequest/warehouse_purchase_order',compact('material_request','sale_order_list','sale_order','regional','project','purchase_orders','purchase_request_lists','products','suppliers'));

    }

    public function ajaxAcceptedWarehouseRequest(Request $request){

    	$products = $request->product_id;

			foreach ($products as $product) {


				// $change_stock->save();
			}
    		return response()->json($product);


		return response()->json($change_stock);
	}

    public function procurement_purchase_request_list(){

    	// $purchase_requests = WarehousePurchaseOrder::where('officer_sent_status','=',null)->get();
        $purchase_requests = WarehousePurchaseOrder::where('officer_sent_status','=',null)->get();

        /*$purchase_request_lists = WarehousePurchaseOrderList::
            select('product_id',DB::raw('SUM(warehouse_purchase_order_lists.stock_qty) as stock_qty'))
            ->groupBy('product_id')
            ->where('officer_sent_status','=',null)
            ->get();*/
        
        // $purchase_request_lists = WarehousePurchaseOrderList::where('officer_sent_status','=',null)->get();
        $purchase_request_lists = WarehousePurchaseOrderList::all();

        // dd($purchase_requests);
    	$products = Product::all();

    	$suppliers = Supplier::all();

        $brand_supp = DB::table('brand_supplier')->get();
        
        $po= OfficerPurchaseOrder::all();

    

    	return view('ProcurementOfficer/PurchaseRequest/procurement_purchase_request_list',compact('po','purchase_requests','purchase_request_lists','products','suppliers','brand_supp'));

    }

    public function procurementPurchaseOrderList(){

    	$purchase_orders = OfficerPurchaseOrder::orderBy('id','desc')->get();
        $purchase_orders_lists = OfficerPurchaseOrderList::all();
        $products = Product::all();
        $purchase_no = WarehousePurchaseOrder::all();
// dd($purchase_orders);
$supplier = Supplier::all();
    	return view('ProcurementOfficer/PurchaseRequest/procurement_purchase_order_list',compact('supplier','purchase_orders','purchase_orders_lists','products','purchase_no'));

    }

    public function createNewPO(Request $request){

        $purchase_order = OfficerPurchaseOrder::create([
            'supplier_id' => $request->supplier_id
        ]);

        $supplier_name = $purchase_order->supplier->name;

        $supplier = Supplier::find($request->supplier_id);
        $brands = $supplier->brand;

        $products = Product::all();
        $po_no = sprintf("%04s", $purchase_order->id);
        $purchase_order->po_no = $po_no;

        $purchase_order->save();

        return response()->json([
            'supplier_name' => $supplier_name,
            'purchase_order' => $purchase_order,
            'supplier_email' => $purchase_order->supplier->email,
            'brands' => $brands,
            'products' => $products,
        ]);

    }

    public function getSupplierProduct(Request $request){

        $supplier = Supplier::find($request->supplier_id);

        $brands = $supplier->brand;

        $products = Product::all();

        return response()->json([
            'brands' => $brands,
            'products' => $products,
            'purchase_requests' => $request->purchase_requests,
            'supplier_id' => $request->supplier_id,
        ]);

    }

    public function send_purchase_order(Request $request, $purchase_request_id){

    	$purchase_order = WarehousePurchaseOrder::find($purchase_request_id);

    	$opo = OfficerPurchaseOrder::create([
    		'purchase_request_id' => $purchase_order->id,
    		'delivery_address' => $request->delivery_address,
    		'supplier_id' => $request->supplier_id,
    	]);
    	
    	$order_num = "OPO-" . $today . sprintf("%04s", $purchase_order->id);

		$opo->po_no = $order_num;
		$opo->save();

    	$purchase_order->sent_status = 1;
    	$purchase_order->save();

    	alert()->success("Successfully Sent Order");
    	return redirect()->back();
    }
    public function SendOfficerPurchaseOrder(Request $request){
        // dd($request->all());
        $pr_str = json_encode($request->pr_list);
        $pr_arr = json_decode($pr_str);
       
    //    dd($pr_arr);
       
        $officer_PO = OfficerPurchaseOrder::where('po_no',$request->po_no)->first();
        $officer_PO->item_list = json_encode($request->item_list);
        $officer_PO->total_qty = $request->total;
       
        $officer_PO->save();

        //find min date of purchase request date to check email date
        $date_arr = [];
        foreach($pr_arr as $pr_lists_date)
        {
        array_push($date_arr,$pr_lists_date->request_date);
        }
        // dd($date_arr);
        // $date_arr = array('0' => '20-05-2015', '1' => '02-01-2015', '2' => '30-03-2015');
       
        for ($i = 0; $i < count($date_arr); $i++)
{
    if ($i == 0)
    {
        $max_date = date('Y-m-d', strtotime($date_arr[$i]));
        $min_date = date('Y-m-d', strtotime($date_arr[$i]));
    }
    else if ($i != 0)
    {
        $new_date = date('Y-m-d', strtotime($date_arr[$i]));
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
                // dd($min_date);

        //end date

       
        foreach($pr_arr as $pr_lists)
        {
            // dd($pr_lists->ware_flag);
            $opo_li = OfficerPurchaseOrderList::create([
                'officer_purchase_order_id' => $officer_PO->id,
                'product_id' => $pr_lists->id,
                'purchase_request_id' => $pr_lists->requestID,
                'purchase_request_no' => $pr_lists->prno,
                'request_qty' => $pr_lists->request_qty,
                'order_qty' =>$pr_lists->qty,
                'warehouse_flag' => $pr_lists->ware_flag,
                'regional_id'=>$pr_lists->regional_id,
                'regional_name' => $pr_lists->reg_name,
                'project_id' => $pr_lists->project_id,
                'phase_id' => $pr_lists->phase_id,
            ]);
        }

        

        foreach($pr_arr as $pr_lists)
        {
            $cal_order = WarehousePurchaseOrderList::where('product_id',$pr_lists->id)->where('warehouse_purchase_order_id',$pr_lists->requestID)->first();

            $cal_order->ordered_qty = $pr_lists->qty;
            $cal_order->stock_qty = $cal_order->stock_qty - $pr_lists->qty;
            $cal_order->save();
        }


        foreach($pr_arr as $pr_lists)
        {
            $change_status = WarehousePurchaseOrderList::where('product_id',$pr_lists->id)->where('warehouse_purchase_order_id',$pr_lists->requestID)->get();
            foreach($change_status as $changes)
            
            if($changes->stock_qty == 0)
            {
                $changes->officer_sent_status = 1;
                $changes->save();
            }
            
        }

       

        foreach($pr_arr as $pr_lists)
        {
        $main_status = WarehousePurchaseOrderList::where('warehouse_purchase_order_id',$pr_lists->requestID)->where('officer_sent_status',null)->first();
        $main_main = WarehousePurchaseOrder::find($pr_lists->requestID);
      
        if($main_status==null)
        {
            
            $main_main->officer_sent_status = 1;
            $main_main->status = 1;
            // dd($main_main->officer_sent_status);
            $main_main->save();
        }
        else{
            $main_main->officer_sent_status = null;
            // dd($main_main->officer_sent_status);
            $main_main->save();
        }
    }
        
        
        
       
        
            
        
        
        return response()->json($min_date);

    }
    public function SaveAllOrder(Request $request){


        if (!empty($request->purchase_request_id)) {
            foreach ($request->purchase_request_id as $value) {
                $purchase_request = WarehousePurchaseOrder::find($value);
                $purchase_request->officer_sent_status = 1;
                $purchase_request->save();

                $purchase_request_lists = WarehousePurchaseOrderList::where('warehouse_purchase_order_id',$value)->get();

                foreach ($purchase_request_lists as $list) {
                    $list->officer_sent_status = 1;
                    $list->save();
                }
            } 
            alert()->info("Successfully Save Order");
            return response()->json($purchase_request);      
        }else{
            alert()->info("No Order to Save");
            return response()->json();   
        }

    }
    public function getsupemail(Request $request){
        $purchase_order = OfficerPurchaseOrder::where('id',$request->po_id)->first();
        $purchase_order_list = OfficerPurchaseOrderList::where('officer_purchase_order_id',$request->po_id)->first();
        $prdate = WarehousePurchaseOrder::where('id',$purchase_order_list->purchase_request_id)->get();
        $prdarr = [];
        foreach($prdate as $prdat)
        {
            array_push($prdarr,$prdat->required_date);
        }

        for ($i = 0; $i < count($prdarr); $i++)
        {
            if ($i == 0)
            {
                $max_date = date('Y-m-d', strtotime($prdarr[$i]));
                $min_date = date('Y-m-d', strtotime($prdarr[$i]));
            }
            else if ($i != 0)
            {
                $new_date = date('Y-m-d', strtotime($prdarr[$i]));
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

        
        $getemail = Supplier::find($purchase_order->supplier_id);
        $supplier_email = $getemail->email;
        // dd($supplier_email);
        return response()->json([
            'supplier_name' => $getemail->name,
            'prcheckdate' => $min_date,
            'supplier_email' => $supplier_email]);
    }
    public function SendMailSupplier(Request $request){
    //    dd($request->all());
    // dd($request->pr_req_date);
    $prdate = OfficerPurchaseOrderList::where('officer_purchase_order_id',$request->po_id)->get();
    
    $prdatearr = [];
    foreach($prdate as $prdatee)
    {
        
        $pr_real_date = WarehousePurchaseOrder::find($prdatee->purchase_request_id);
        array_push($prdatearr,$pr_real_date->required_date);
    }
    dd($prdatearr);
    //Correct Date Check Begin PR an PO
    for ($i = 0; $i < count($prdatearr); $i++)
    {
        if ($i == 0)
        {
            $max_date = date('Y-m-d', strtotime($prdatearr[$i]));
            $min_date = date('Y-m-d', strtotime($prdatearr[$i]));
        }
        else if ($i != 0)
        {
            $new_date = date('Y-m-d', strtotime($prdatearr[$i]));
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


    //End Date Check
    $pr_date = \Carbon\Carbon::parse($min_date);
    $mail_date = \Carbon\Carbon::parse($request->req_date);
   
    $result = $mail_date->diffInDays($pr_date, false);
    // dd($result);
   
        if($result < 0)
        {
            // dd("no");
            $late = $result * -1;
            return response()->json([
                'latee' => 1,
                
                'late' => $late]);
        }
        else
        {
            // dd("yes");
            $purchase_order = OfficerPurchaseOrder::where('po_no',$request->po_no)->first();
            // dd($purchase_order);
            $purchase_order->po_date = $mail_date;
            $purchase_order->save();
            $brand = OfficerPurchaseOrderList::where('officer_purchase_order_id',$purchase_order->id)->get();
            
            // dd($purchase_order->item_list);
            $supplier_name = $purchase_order->supplier->name;
            $subject = $request->subject;
            $body_text = $request->body_text;
            $email = $request->email;
            // dd($email);
            $req_date = $request->req_date;
            // dd($req_date);
            $data = [
                'supplier_name' => $purchase_order->supplier->name,
                'req_date' => $request->req_date,
                'subject' => $request->subject,
                'email' => $request->email,
                'body' => $request->body,
            ];
    
            // Mail::send('mail.index',['req_date'=>$req_date,'supplier_name'=>$supplier_name,'body_text'=>$body_text,'item_list'=>json_encode($purchase_order->item_list)], function($message) use ($data){
                
            //     $email = 'kokoshine3499@gmail.com';
            //     $message->sender($email, 'Ko Zaw');
            //     $message->from($email, 'K-Win Technologies');
            //     $message->to($data['email'],'zaw');
            //     $message->cc('kokoshine3499@gmail.com','KoWin');
            //     $message->subject($data['subject']);
            // });
           
            Mail::send('mail.index',['req_date'=>$req_date,'supplier_name'=>$supplier_name,'body_text'=>$body_text,'item_list'=>$brand], function($message) use ($data){
                
                $email = 'kokoshine3499@gmail.com';
                
                $message->sender($email, 'Ko Zaw');
                
                $message->from($email, 'K-Win Technologies');
               
                $message->to($data['email'],'zaw');
               
                $message->cc('kokoshine3499@gmail.com','KoWin');
                $message->subject($data['subject']);
            });
          
            $purchase_order->mail_sent = 1;
            $purchase_order->save();
            // alert()->success("Successfully Send Email!");
            return response()->json($purchase_order);
            // return redirect()->back();
        }

		
			
		
        // dd($request->po_no);
       

    }
   
}
