<?php

namespace App\Http\Controllers\api;


use App\Item;
use App\User;
use App\Defect;
use App\Product;
use App\Brand;
use App\ProductList;
use App\ProjectPhase;
use App\ReceiveOrder;
use App\DeliveryOrder;
use App\PurchaseOrder;
use App\SiteInventory;
use App\RejectProducts;
use App\GoodReceiveNote;
use App\MaterialRequest;
use App\DeliveryOrderList;
use App\MaterialRequestList;
use Illuminate\Http\Request;
// use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\GoodResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIBaseController;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\MaterialRequestResource;
use App\Http\Resources\PurchaseOrderListResource;
use App\Http\Resources\MaterialRequestListResource;


class SiteController extends APIBaseController {

//Purchase Order
	public function Purchase_Orderlist(Request $request) {

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}

		$user_id = $request->user_id;

		$user = User::find($user_id);

		if (is_null($user->work_site_id)) {

			return $this->sendFailResponse("This User Is Not Associated With Work Site");

		}
		$purchase_order = PurchaseOrder::where('work_site_id', $user->work_site_id)->orderBy('id', 'desc')->get();

		$purchase_order_list = ProductList::all();

		// $order_list = ProductListResource::collection($purchase_order_list);

		$purchase_orders = PurchaseOrderListResource::collection($purchase_order);

		return response()->json([
			'purchase_orders' => $purchase_orders,
		]);
	}

	public function item_list_details(Request $request){

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'purchase_order_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		$user_id = $request->user_id;

		$user = User::find($user_id);

		if (is_null($user->work_site_id)) {

			return $this->sendFailResponse("This User Is Not Associated With Work Site");

		}

		$item_list = ProductList::where('purchase_order_id',$request->purchase_order_id)->get();

		$item_lists = ProductListResource::collection($item_list);

		return response()->json([
			'item_lists' => $item_lists,
		]);

	}

	public function site_order_list_item(Request $request){

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}

		$user_id = $request->user_id;

		$user = User::find($user_id);

		if (is_null($user->work_site_id)) {

			return $this->sendFailResponse("This User Is Not Associated With Work Site");

		}
		$purchase_order_list = ProductList::all();

		$order_list = ProductListResource::collection($purchase_order_list);

		return response()->json([
			'purchase_order_list' => $order_list,
		]);
	}

	public function Purchase_Order_Create(Request $request) {

		/*$validator = Validator::make($request->all(), [
				'user_id' => 'required',
			]);
		*/
		/*if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}*/

		$item = Item::all();

		return $this->sendSuccessResponse('item', $item);
	}

	public function Purchase_Order_Store(Request $request) {

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'item_list' => 'required',
			'date' => 'required',
		]);

		if ($validator->fails()) {

			return response()->json(['error', $validator->errors()]);
		}

		$user_id = $request->user_id;

		$user = User::find($user_id);

		if (is_null($user->work_site_id)) {

			return $this->sendFailResponse("This User Is Not Associated With Work Site");

		}

		$user_work_site = $user->work_site_id;

		$today = date('d');

		$purchase_order = PurchaseOrder::create([
			'project_name' => $request->project_name,
			'customer_name' => $request->customer_name,
			'phone' => $request->phone,
			'work_site_id' => $user_work_site,
			'request_date' => $request->date,
			'item_list' => $request->item_list,
			'site_status' => 0,
			'status' => 0,
		]);
		
		$order_num = "PO" . $today . sprintf("%04s", $purchase_order->id);

		$purchase_order->order_code = $order_num;

		$purchase_order->save();

		foreach ($purchase_order->item_list as $item) {

			ProductList::create([
				'product_id' => $item->product_id,
				'purchase_order_id' => $purchase_order->id,
				'stock_qty' => $item->stock_qty,
			]);
		}

		return $this->sendSuccessResponse('purchase_order', $purchase_order);
	}

//Material Requests
	public function site_material_request_store(Request $request){

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'item_list' => 'required',
			'date' => 'required',
		]);

		if ($validator->fails()) {

			return response()->json(['error', $validator->errors()]);
		}
		// $array = json_encode($request->item_list);

		// dd($array);
		// foreach ($array as $itemm)
		// {
		// 	dd($itemm->product_id);
		// }
		
		$user_id = $request->user_id;

		$user = User::find($user_id);

		if (is_null($user->work_site_id)) {

			return $this->sendFailResponse("This User Is Not Associated With Work Site");

		}

		$user_work_site = $user->work_site_id;

		$today = date('d');
		
		$material_request = MaterialRequest::create([
			'request_date' => $request->date,
			// 'item_list' => json_encode($request->item_list),
			'site_status' => 0,
			'user_id' => $user_id,
			'status' => 0,
		]);

		$order_num = "MR" . $today . sprintf("%04s", $material_request ->id);

		$material_request->request_code = $order_num;

		$material_request->save();
		
		// dd($material_request->item_list);
		
		foreach ($material_request->item_list as $item) {
			
			$material_request_lists = MaterialRequestList::create([
				'product_id' => $item->product_id,
				'material_request_id' => $material_request->id,
				'request_qty' => $item->stock_qty,
			]);
		}
		
// 		$material_requests = MaterialRequestListResource::collection($material_request_lists);
        $material_requests = MaterialRequest::select('id', 'request_code', 'request_date','status')->find($material_request->id);

		return response()->json(['data'=>$material_requests]);

	}
	//Material Request List Show
	public function material_request_list(Request $request) {

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}

		$user_id = $request->user_id;

		$user = User::find($user_id);

		if (is_null($user->work_site_id)) {

			return $this->sendFailResponse("This User Is Not Associated With Work Site");

		}
		
		$material_request = MaterialRequest::orderBy('id', 'desc')->where('user_id',$user_id)->get();

		$material_requests = MaterialRequestResource::collection($material_request);

		return response()->json([
			'material_requests' => $material_requests,
		]);
	}

	public function material_item_list(Request $request){
		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
// 			'material_request_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		$user_id = $request->user_id;

		$user = User::find($user_id);

		$material_request = MaterialRequest::where('user_id',$user_id)->find($request->material_request_id);

// 		$material_request_list = MaterialRequestList::where('material_request_id',$material_request->id)->get();
		$material_request_list = MaterialRequestList::all();

		$material_request_lists = MaterialRequestListResource::collection($material_request_list);

		// return response()->json(is_array($material_request_list));
		return $this->sendSuccessResponse('data',$material_request_lists);
	}

	public function Receive_Order(Request $request) {

		$validator = Validator::make($request->all(), [
			'purchase_order_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		$id = $request->purchase_order_id;

		$purchase_order = PurchaseOrder::find($id);

		return $this->sendSuccessResponse('purchase_order', $purchase_order);
	}

	public function Receive_Order_Store(Request $request) {

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'purchase_order_id' => 'required',
			'arrival_date' => 'required|date',
			'status' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}

		$status = $request->status;

		$receive_order = ReceiveOrder::create([
			'purchase_order_id' => $request->purchase_order_id,
			'employee_id' => $request->user_id,
			'request_qty' => $request->request_qty,
			'arrival_date' => $request->arrival_date,
			'status' => $status,
		]);

		$purchase_order = PurchaseOrder::find($request->purchase_order_id);

		$receive_order_id = $receive_order->id;
		$purchase_order->site_status = 2;
		$purchase_order->save();

		if ($status == "defects") {

			$defect = Defect::create([
				'qty' => $request->qty,
				'comment' => $request->comment,
				'receive_order_id' => $receive_order_id,
			]);
		}

		return $this->sendSuccessResponse('receive_order', $receive_order);

	}
	public function Purchase_Order_Group(Request $request) {
		$purchase_order_id = $request->purchase_order_id;
		$eta_date = $request->eta_date;
		$group_id = date('ymd', strtotime($eta_date));

		foreach ($purchase_order_id as $po) {
			$purchase_orders = PurchaseOrder::find($purchase_order->id);
			$purchase_orders->status = 1;
			$purchase_orders->site_status = 1;
			$purchase_orders->eta_date = $request->eta_date;
			$purchase_orders->save();

			$purchase_order_group = PurchaseOrderGroup::create([
				'group_id' => $group_id,
				'group_name' => $request->group_name,
				'purchase_order_id' => $$purchase_order_id[$po],

			]);
		}
		return $this->sendSuccessResponse('purchase_order_group', $purchase_order_group);
	}

	public function product_list() {
		$products = Product::all();

		return response()->json([
			'product_list' => $products,
		]);
	}

	public function sendsitegrn(Request $request){
	    
	    $validator = Validator::make($request->all(), [
			'work_site_id' => 'required',
			'phase_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		
		$work_site_id = $request->work_site_id;
		$phase_id = $request->phase_id;
	    
		$goodnote = GoodReceiveNote::where('warehouse_flag',null)->where('change_status',0)->where('work_site_id',$work_site_id)->where('project_phase_id',$phase_id)->get();
		
		return $this->sendSuccessResponse('data',$goodnote);
	}
	public function site_grn_product_details(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'grn_id' => 'required',
		
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		$grnID = $request->grn_id;
		$goodnotes = GoodReceiveNote::find($grnID);
		$goodnote_products = DB::table('good_receive_note_product')
		->where('good_receive_note_id',$goodnotes->id)
		// ->where('change_status',0)
		->get();
		
		$goodnote_finalproducts=array();
		foreach($goodnote_products as $gn_product){
		    $product_detail = Product::where('id',$gn_product->product_id)->first();
		    $brand_id = $product_detail->brand_id;
		    $serial_number = $product_detail->serial_number;
		    $model_number = $product_detail->model_number;
		    $measuring_unit = $product_detail->measuring_unit;
		    $brand_detail = Brand::where('id',$brand_id)->first();
		    $brand_name = $brand_detail->name;
		    $coo = $brand_detail->country_of_origin;
		    $final_product_detail = array(
		            'product_id' => $gn_product->product_id,
		            'product_name' => $gn_product->product_name,
		            'quantity' => $gn_product->quantity,
		            'status' => $gn_product->status,
		            'change_status' => $gn_product->change_status,
		            'brand_name' => $brand_name,
		            'serial_number' => $serial_number,
		            'model_number' => $model_number,
		            'coo' => $coo,
		            'grn_id' => $gn_product->good_receive_note_id
		        );
		       array_push($goodnote_finalproducts,$final_product_detail);
		}
		
		return $this->sendSuccessResponse('data',$goodnote_finalproducts);
	}
	public function accept_site_product(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'grn_id' => 'required',
			'product_id' => 'required',
			'phase_id' => 'required',
			
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		$goodID = $request->grn_id;
		$productID = $request->product_id;
		
		$project_phase_id = $request->phase_id;
		$projectid = ProjectPhase::find($project_phase_id);
		$goodreceiveid = GoodReceiveNote::find($goodID);
		$goodproduct = DB::table('good_receive_note_product')
		->where('good_receive_note_id',$goodID)
		->where('change_status',0)
		->first();
		$product_all = Product::find($goodproduct->product_id);
		$site_inventory = SiteInventory::where('product_id',$product_all->id)->first();
		if(!empty($site_inventory))
		{
			$site_inventory->delivered_qty +=$goodproduct->quantity;
			$site_inventory->save();
		}
		else{
			$site_invent = SiteInventory::create([
				'product_id' => $productID,
				'model_number' => $product_all->model_number,
				'measuring_unit' => $product_all->measuring_unit,
				'name' => $product_all->name,
				'brand_name' => $product_all->brand->name,
				'delivered_qty' => $goodproduct->quantity,
				'project_id' => $projectid->project_id,
				'phase_id' => $project_phase_id,
				'flag' => 0,
			]);
		}
		$good_receive_product = DB::table('good_receive_note_product')
		->where('good_receive_note_id',$goodID)
		->first();
		
		$affected = DB::table('good_receive_note_product')
              ->where('good_receive_note_id',$goodID)
			  ->where('product_id',$productID)
              ->update(['change_status' => 1]);
		$gproducts = DB::table('good_receive_note_product')
		->where('good_receive_note_id',$goodID)
		->where('change_status',0)
		->get();
		if(count($gproducts) == 0)
		{
			$goodreceiveid->change_status = 1;
			$goodreceiveid->save();
		}
		
		

		// return response()->json($product_all->brand->name);
		return response()->json([
			'status' => 201,
			'message' => 'Successfully Accepted',
			'data' => $goodreceiveid
			]); 

	}

	public function reject_site_product(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'grn_id' => 'required',
			'product_id' => 'required',
			'phase_id' => 'required',
			
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		$remark = $request->remark;
		$goodID = $request->grn_id;
		$productID = $request->product_id;
		
		$project_phase_id = $request->phase_id;
		$products= Product::find($productID);
		$good_receive_note = GoodReceiveNote::find($goodID);
		$good_receive_products = DB::table('good_receive_note_product')
		->where('good_receive_note_id',$goodID)
		->where('product_id',$productID)
		->first();

		

		$RejectList = RejectProducts::create([
			'grn_no' => $good_receive_note->grn_no,
			'product_id' => $productID,
			'product_name' => $products->name,
			'good_receive_note_id' => $goodID,
			'regional_name' => "Site",
			'quantity' => $good_receive_products->quantity,
			'category_name' => $good_receive_products->category_name,
			'supplier' => $good_receive_products->supplier,
			'purchase_price' => $good_receive_products->purchase_price,
			'remark' => $remark,
			'project_phase_id' => $project_phase_id,
		]);
		// dd($goodID);
		
		$affected = DB::table('good_receive_note_product')
              ->where('good_receive_note_id',$goodID)
			  ->where('product_id',$request->product_id)
              ->update(['change_status' => 2]);
		
		$gproducts = DB::table('good_receive_note_product')
		->where('good_receive_note_id',$goodID)
	
		->where('change_status',0)
		->get();
		// dd($gproducts);
		if(count($gproducts) == 0)
		{
			$good_receive_note->change_status = 1;
			$good_receive_note->save();
		}
		
			
	
	


		// return response()->json("success");
		return response()->json([

			'status' => 201,
			'message' => 'Successfully rejected',
			'data' => $good_receive_note
			]); 
	}

}
