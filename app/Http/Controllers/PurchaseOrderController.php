<?php

namespace App\Http\Controllers;
use DateTime;
use App\Brand;
use App\Product;
use App\Project;
use App\Category;
use App\Customer;
use App\Document;
use App\WorkSite;
use App\SaleOrder;
use App\ProductList;
use App\ProjectPhase;
use App\DeliveryOrder;
use App\MaterialIssue;
use App\PurchaseOrder;
use App\SaleOrderList;
use App\SiteInventory;
use App\MaterialRequest;
use App\DeliveryOrderList;
use App\MaterialIssueList;
use App\RegionalWarehouse;
use App\MaterialRequestList;
use Illuminate\Http\Request;
use App\OfficerPurchaseOrder;
use App\WarehousePurchaseOrder;
use App\WarehousePurchaseOrderList;


class PurchaseOrderController extends Controller {

	//Material Request
	public function purchase_order_list() {

		$purchase_orders = PurchaseOrder::all();

		$product_lists = ProductList::all();

		return view('Manager/Purchase_Order/purchase_order_list', compact('purchase_orders', 'product_lists'));
	}

	//Site Purchase Order
	public function purchase_order() {

		$purchase_orders = PurchaseOrder::all();

		$product_lists = ProductList::all();

		return view('Manager/Purchase_Order/purchase_order_list', compact('purchase_orders', 'product_lists'));
	}

	//Warehouse Purchase Order
	public function warehouse_purchase_order(){
		$officer_purchase_orders = OfficerPurchaseOrder::all();

		return view('Manager/Purchase_Order/warehouse_purchase_order',compact('officer_purchase_orders'));
	}
	public function approveOfficerOrder(Request $request){
	    
	   $officer_purchase_order = OfficerPurchaseOrder::find($request->purchase_order_id);
	   $officer_purchase_order->approve = 1;
	   $officer_purchase_order->save();
	    
	    return response()->json($officer_purchase_order);
	}

	public function sales_order($purchase_order_id) {

		$purchase_orders = PurchaseOrder::find($purchase_order_id);

		$product_lists = ProductList::all();

		$projects = Project::all();

		$project_phases = ProjectPhase::all();

		$products = Product::all();

		$category = Category::all();

		return view('Manager/Purchase_Order/sales_order', compact('category','purchase_orders', 'product_lists', 'projects', 'project_phases', 'products'));

	}

	public function sales_order_manual()
	{
		
		$purchase_orders = PurchaseOrder::all();
		$product_lists = ProductList::all();

		$projects = Project::all();

		$project_phases = ProjectPhase::all();

		$products = Product::all();

		$category = Category::all();

		

		return view('Manager/Purchase_Order/sales_order_manual', compact('purchase_orders','category', 'product_lists', 'projects', 'project_phases', 'products'));
	}

	public function ajaxGetcateproducts(Request $request)
	{
		// dd($request->category_id);
		$product_cate = Product::where('category_id',$request->category_id)->get();
		$category = Category::find($request->category_id);
		$brand_arr = [];
		foreach($product_cate as $pro)
		{
			// dd($pro->brand->name);
			array_push($brand_arr,$pro->brand->name);
		}
		return response()->json([
			'brand' => $brand_arr,
			'cate' => $category->name,
			'product' => $product_cate 
		]);
	}
	public function ajaxPurchaseOrder_detail(Request $request)
	{
		// dd($request->purchase_order_id);
		$purchase_order = PurchaseOrder::find($request->purchase_order_id);
		// dd($purchase_order->id);
		$product_lists = ProductList::where('purchase_order_id',$purchase_order->id)->get();
		$stock = [];
		$pro_name = [];
		$brand = [];
		foreach($product_lists as $product)
		{
			$products = Product::find($product->product_id);
			array_push($pro_name,$products->name);
			array_push($stock,$product->stock_qty);
			array_push($brand,$products->brand->name);
		}
		return response()->json([
			'order_code' => $purchase_order->order_code,
			'customer_name' => $purchase_order->customer_name,
			'phone' => $purchase_order->phone,
			'request_date' => $purchase_order->request_date,
			'pro_name' => $pro_name,
			'stock' => $stock,
			'brand' => $brand,
			

		]);
	}

	public function ajaxPhase(Request $request) {
		
		$project = Project::find($request->id);
		// dd($project);
		$project_phases = ProjectPhase::where('project_id', $project->id)->get();

		return response()->json($project_phases);

	}
	public function ajaxDeliveryDate(Request $request) {

		$project_phases = ProjectPhase::find($request->id);

		return response()->json($project_phases);

	}

	public function ajaxAddSaleOrder(Request $request) {

		$product = Product::find($request->id);

		return response()->json($product);

	}

	//Purchase Order Store
	public function ajaxSalesOrder(Request $request){
// dd($request->all());
		$project_id = $request->project_id;
		$phase_id = $request->phase_id;
		$sales_order = $request->sales_order;
		$delivery_date = $request->delivery_date;
		$purchase_order_id = $request->purchase_order_id;
		
		$sale_orders = SaleOrder::create([
			'purchase_order_id' => $purchase_order_id,
			'phase_id' => $phase_id,
			'sale_order_list' => $sales_order,
			'delivery_date' => $delivery_date,
			'project_id' => $project_id,
			'status' => 0,
		]);
		
		$order_num = "SO-" .sprintf("%04s", $purchase_order_id);

		$sale_orders->sale_no = $order_num;
		$sale_orders->save();

		$purchase_order = PurchaseOrder::find($sale_orders->purchase_order_id);

		$purchase_order->warehouse_status = 1;
		$purchase_order->save();

		$item_list = $sale_orders->sale_order_list;

		foreach ($item_list as $item) {

			SaleOrderList::create([
				'product_id' => $item->id,
				'sale_order_id' => $sale_orders->id,
				'stock_qty' => $item->qty,
			]);
		}
		
		return response()->json($sales_order);

	}

	//Warehouse Sale Order Check List
	public function warehouse_sale_orders(){
		$sale_orders = SaleOrder::all();

		$sale_order_lists = SaleOrderList::all();
		$material_request = MaterialRequest::all();
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

		return view('Warehouse/SaleOrder/sale_order_list',compact('prefix','digit','index','material_request','sale_orders','sale_order_lists','products'));
	}

	public function ajaxSendMaterialIssue(Request $request){
		// dd($request->digit);
		if($request->material_request_id){
		    $material_request = MaterialRequest::find($request->material_request_id);
		    $material_request->warehouse_status = 1;
    		$phase = ProjectPhase::where('user_id',$material_request->user_id)->first();
    		
    		$project = Project::find($phase->project_id);
    		
    		$material_request->site_status = 0;
    		$material_request->dispatch_date = date('Y-m-d');
    		$material_request->save();
    		
    		$material_request_lists = json_encode($material_request->item_list);
			$total_qty_arr = json_decode($material_request_lists);

			// dd($total_qty_arr);
		
			$total = [];
			foreach($total_qty_arr as $total_ar)
			{
				array_push($total,$total_ar->stock_qty);
			}
			$tot = array_sum($total);
    		// dd("ye");
    		$material_issue = MaterialIssue::create([
				
    			'purchase_order_id' => $purchase_order->id??null,
    			'material_request_id' => $material_request->id??null,
				'prefix_syntax' => $request->prefix,
				'index_digit' => $request->digit,
    			'project_id' => $project->id,
    			'phase_id' => $phase->id,
    			'item_list' => $material_request_lists,
    			'approve' => 0,
				'total_qty' => $tot,
    			'approve_delivery_order' => 0,
    			'delivery_order_status' => 0,
    			'status' => 0,
    			'warehouse_transfer_status' => 0,
    		]);
			$mi_no = $material_issue->prefix_syntax."-".sprintf("%0".$request->digit."s", $material_issue->id);
			$material_issue->material_issue_no = $mi_no;
			$material_issue->save();
    		
    		foreach ($material_request->item_list as $item_list) {
    			MaterialIssueList::create([
    				'material_issue_id' => $material_issue->id,
    				'product_id' => $item_list->product_id,
    				'stock_qty' => $item_list->stock_qty,
    			]);
    
    			$product = Product::find($item_list->product_id);
    			$product->stock_qty -= $item_list->stock_qty;
    			$product->reserved_qty += $item_list->stock_qty;
    			$product->save();
    
    		}
		}
		
		if($request->sale_order_id) {
		    $sale_orders = SaleOrder::find($request->sale_order_id);
    		$sale_orders->material_issue_status = 1;
    		$sale_orders->save();
    		
    		
    		
    		$sale_order_lists = SaleOrderList::where('sale_order_id',$sale_orders->id)->get();
    
    		$project = Project::find($sale_orders->project_id);
    
    		$phase = ProjectPhase::find($sale_orders->phase_id);
    
    		//Changing Site Status of po when warehosue sending to Site
    		$purchase_order = PurchaseOrder::find($sale_orders->purchase_order_id);
    		
    		$purchase_order->site_status = 0;
    		$purchase_order->dispatch_date = date('Y-m-d');
    		$purchase_order->save();
    		
    		$sale_order_list = json_encode($sale_orders->sale_order_list);
			$total_qty_arr_sale = json_decode($sale_order_list);

			// dd($total_qty_arr);
		
			$total = [];
			foreach($total_qty_arr_sale as $total_arr)
			{
				array_push($totalsale,$total_arr->stock_qty);
			}
			$tot = array_sum($totalsale);
    		
    		$material_issue = MaterialIssue::create([
    			'purchase_order_id' => $purchase_order->id??null,
    			'material_request_id' => $request->material_request_id??null,
				'prefix_syntax' => $request->prefix,
				'index_digit' => $request->digit,
    			'project_id' => $sale_orders->project_id,
    			'phase_id' => $sale_orders->phase_id,
    			'item_list' => $sale_order_list,
    			'approve' => 0,
    			'approve_delivery_order' => 0,
    			'delivery_order_status' => 0,
				'total_qty' => $totalsale,
    			'status' => 0,
    			'warehouse_transfer_status' => 0,
    		]);
			$mi_no = $material_issue->prefix_syntax."-".sprintf("%0".$request->digit."s", $material_issue->id);
			$material_issue->material_issue_no = $mi_no;
			$material_issue->save();

    		//Change Warehouse Inventory stock
    	    foreach ($sale_order_lists as $item_list) {
    			MaterialIssueList::create([
    				'material_issue_id' => $material_issue->id,
    				'product_id' => $item_list->product_id,
    				'stock_qty' => $item_list->stock_qty,
    			]);
    
    			$product = Product::find($item_list->product_id);
    			$product->stock_qty -= $item_list->stock_qty;
    			$product->reserved_qty += $item_list->stock_qty;
    			$product->save();
    
    		}
		}

		return response()->json([
			'product' => $product,
			'material_issue' => $material_issue,
		]);

	}

	public function each_stockCheck_ajax(Request $request)
	{
		// dd($request->request_id);
		$arra = [];
		$material_request = MaterialRequest::find($request->request_id);
		// dd($material_request->item_list);
		// dd($material_request->item_list);
		$material_item_list = MaterialRequestList::where('material_request_id',$request->request_id)->get();

		foreach($material_item_list as $proname)
		{
			// dd($proname);
			array_push($arra,$proname);
			// dd($arra);
			$producttable = Product::find($proname->product_id);
			// dd($producttable->stock_qty."jjj".$proname->request_qty);
			// dd($proname->stock_qty);
			if($proname->request_qty > $producttable->stock_qty  )
			{
				// dd("less");
				
				return response()->json("l");
			}
			else
			{
				// return response()->json("g");
			}
			
			
			
			
			
		}
		// dd($arra);
// dd($proname->stock_qty);
		// dd($preq);

		// return response()->json();
	}
	public function each_stockCheck_sale_ajax(Request $request)
	{
		// dd($request->request_id);
		$arra = [];
		$sale_order = SaleOrder::find($request->order_id);
		// dd($material_request->item_list);
		// dd($material_request->item_list);
		$sale_order_list = SaleOrderList::where('sale_order_id',$request->order_id)->get();

		foreach($sale_order_list as $proname)
		{
			// dd($proname);
			array_push($arra,$proname);
			// dd($arra);
			$producttable = Product::find($proname->product_id);
			// dd($producttable->stock_qty."jjj".$proname->request_qty);
			// dd($proname->stock_qty);
			if($proname->stock_qty > $producttable->stock_qty  )
			{
				// dd("less");
				
				return response()->json("l");
			}
			else
			{
				// return response()->json("g");
			}
			
			
			
			
			
		}
		// dd($arra);
// dd($proname->stock_qty);
		// dd($preq);

		// return response()->json();
	}

	public function show_material_issue_list()
	{
		$material_issue = MaterialIssue::all();
		$material_issue_list = MaterialIssueList::all();
		return view('Warehouse/MaterialIssue/material_issue_list',compact('material_issue','material_issue_list'));
	}

	public function warehouse_po_create($sale_order_id){

		$sale_order_id = $sale_order_id;

		$sale_order = SaleOrder::find($sale_order_id);

		$sale_order_lists = SaleOrderList::where('sale_order_id',$sale_order->id)->get();
		

		$projects = Project::all();

		$products = Product::all();

		$project_phases = ProjectPhase::all();

		// $required_product = array();

		/*foreach ($products as $product) {
			foreach ($sale_order_lists as $item_list) {
				if($product->id == $item_list->product_id){
					if ($product->stock_qty < $item_list->stock_qty) {
						$stock_qty = $item_list->stock_qty - $product->stock_qty;

					}
				}
			}
		}*/

		return view ('Warehouse/PurchaseOrder/purchase_order',compact('sale_order','projects','project_phases','products','sale_order_lists'));
	}

	public function warehouse_pr_create($material_request_id){

		$material_request_id = $material_request_id;

		$material_request = MaterialRequest::find($material_request_id);
		

		$material_request_lists = MaterialRequestList::where('material_request_id',$material_request->id)->get();
		

		$projects = Project::all();

		$products = Product::all();

		$project_phases = ProjectPhase::all();

		$brand = Brand::all();

		// $required_product = array();

		/*foreach ($products as $product) {
			foreach ($sale_order_lists as $item_list) {
				if($product->id == $item_list->product_id){
					if ($product->stock_qty < $item_list->stock_qty) {
						$stock_qty = $item_list->stock_qty - $product->stock_qty;

					}
				}
			}
		}*/
		// $material_request->save();

		 
        $products = Product::all();
        
       
        
        $projects = Project::all();
        
        $project_phases = ProjectPhase::all();
        
        $work_sites = WorkSite::all();

        $regionalname = RegionalWarehouse::all();
		return view ('Warehouse/PurchaseOrder/purchase_request',compact('brand','regionalname','work_sites','products','projects','project_phases','material_request','projects','project_phases','products','material_request_lists'));
	}

	public function ajaxSendWarehousePO(Request $request){
		// dd($request->all());
		$project_id = $request->project_id;
		$phase_id = $request->phase_id;
		$required_date = $request->required_date;
		$required_product = $request->required_product;
		$sale_order_id = $request->sale_order_id;
		$regional_name = RegionalWarehouse::find($request->regional_id);
		if($regional_name == null)
		{
			$regional = null;
			
		}
		else
		{
			$regional = $regional_name->warehouse_name;
		}
		if($request->material_request_id == null)
		{
				$mat_req = null;
				$sale_order_ID = $sale_order_id;
		}
		else
		{
			$mat_req = $request->material_request_id;
			$sale_order_ID = null;
		}
		//Sending Warehouse PO when stock is not enough for sale order
		
		$purchase_order = WarehousePurchaseOrder::create([
			'project_id' => $project_id,
			'phase_id' => $phase_id,
			'required_date' => $required_date,
			'item_list' => json_encode($required_product),
			'sent_stauts' => 0,
			'officer_sent_status' => 0,
			'priority' => 'urgent',
			'status' => 0,
			'material_request_id' => $mat_req,
			'sale_order_id' => $sale_order_ID,
			'destination_flag' => $request->warehouse_flag,
			'destination_regional_id' => $request->regional_id,
			'regional_name' => $regional, 
		]);
		// dd("well");
		$order_num = "WPR-" . sprintf("%04s", $purchase_order->id);
		
		$purchase_order->pr_no = $order_num;
		$purchase_order->save();
		if($request->material_request_id != null)
		{
		$material_req = MaterialRequest::find($request->material_request_id);
		$material_req->purchase_flag = 1;
		$material_req->purchase_req_no = $purchase_order->pr_no;
		$material_req->save();
		}
		// dd($purchase_order->item_list[0]);
		if($request->material_request_id == null)
		{
			$mat_req = null;
			$product_list = json_decode($purchase_order->item_list);
		}
		else{
			$mat_req = $request->material_request_id;
			$product_list = json_decode($purchase_order->item_list[0]);
		}
		
		// $product_list = json_decode($purchase_order->item_list[0]);
		// dd($purchase_order->item_list);
		foreach ($product_list as $item_list) {
			// dd($item_list->product_id);
			$wh_po = WarehousePurchaseOrderList::create([
				'warehouse_purchase_order_id' => $purchase_order->id,
				'product_id' => $item_list->product_id,
				'now_qty' => $item_list->stock_qty,
				'stock_qty' => $item_list->stock_qty,
				
				'material_request_id' => $mat_req,
			]);
	
		}

		$material_requests = MaterialRequest::all();

		$material_request_lists = MaterialRequestList::all();

		$products = Product::all();

		$product_array = WarehousePurchaseOrderList::where('warehouse_purchase_order_id',$purchase_order->id)->get();
		$true_request = WarehousePurchaseOrderList::all();
		// dd($product_array);
		alert()->success("Successfully Purchase Requested!!");
		return redirect()->back();
		// return view('Warehouse/MaterialRequest/material_request_list',compact('material_requests','material_request_lists','products','product_array','true_request'));

	}
	public function ajaxSendWarehousePR(Request $request){

		$project_id = $request->project_id;
		$phase_id = $request->phase_id;
		$required_date = $request->required_date;
		$required_product = $request->required_product;
		$material_request_id = $request->material_request_id;

		//Sending Warehouse PO when stock is not enough for sale order
		
		$purchase_order = WarehousePurchaseOrder::create([
			'project_id' => $project_id,
			'phase_id' => $phase_id,
			'required_date' => $required_date,
			'item_list' => $required_product,
			'sent_stauts' => 0,
			'officer_sent_status' => 0,
			'priority' => 'urgent',
			'status' => 0,
		]);
		
		$order_num = "WPR-" . $today . sprintf("%04s", $purchase_order->id);

		$purchase_order->pr_no = $order_num;
		
		$purchase_order->save();
			
		foreach ($purchase_order->item_list as $item_list) {

			$wh_po = WarehousePurchaseOrderList::create([
				'warehouse_purchase_order_id' => $purchase_order->id,
				'product_id' => $item_list->product_id,
				'now_qty' => $item_list->stock_qty,
				'stock_qty' => $item_list->stock_qty,
			]);
		}

		return response()->json([
			'data' => $purchase_order,
			'wh_po' => $wh_po,
		]);

	}


	//Sale Console
	public function sale_purchase_order_list(){

		$purchase_orders = PurchaseOrder::all();

		$purchase_order_lists = ProductList::all();

		return view('Sale/PurchaseOrder/sale_purchase_order_list',compact('purchase_orders','purchase_order_lists'));
	}

	public function sale_purchase_order(){

		$products = Product::all();

		$customers = Customer::all();

		$documents = Document::all();

		return view('Sale/PurchaseOrder/sale_purchase_order',compact('products','customers','documents'));

	}

	public function ajaxSalePurchaseOrder(Request $request){
		$project_name = $request->project_name;
		$customer_id = $request->customer_id;
		$description = $request->description;
		$document_id = $request->document_id;
		$phone = $request->phone;
		$request_date = $request->request_date;
		$purchase_order = $request->purchase_order;
		
		$customer = Customer::find($customer_id);

		// if ($request->hasfile('file')) {

		// 	$file = $request->file('file');
		// 	$name = $file->getClientOriginalName();
		// 	$file->move(public_path() . '/files/', $name);
		// 	$file = $name;
		// }

		$purchase_order = PurchaseOrder::create([
			'project_name' => $project_name,
			'customer_name' => $customer->company_name,
			'customer_id' => $customer_id,
			'description' => $description,
			'document_id' => $document_id,
			'item_list' => $purchase_order,
			'request_date' => $request_date,
			'phone' => $phone,
			'site_status' => 0,
		]);

		$order_num = "SPO-" . sprintf("%04s", $purchase_order->id);

		$purchase_order->order_code = $order_num;

		$purchase_order->save();

		$item_list = $purchase_order->item_list;

		foreach ($item_list as $item) {

			ProductList::create([
				'purchase_order_id' => $purchase_order->id,
				'product_id' => $item->id,
				'stock_qty' => $item->qty,
			]);
		}
		
		return response()->json($purchase_order);
	}
}