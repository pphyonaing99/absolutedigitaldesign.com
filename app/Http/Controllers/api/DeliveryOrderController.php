<?php

namespace App\Http\Controllers\api;

use App\User;
use App\Brand;

use App\Project;


use App\Product;
use App\Project;
use App\SaleOrder;
use App\DeliveryOrder;
use App\PurchaseOrder;
use App\SiteInventory;
use App\DeliveryOrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIBaseController;
use App\Http\Resources\DeliveryOrderResource;
use App\Http\Resources\DeliveryOrderListResource;

class DeliveryOrderController extends APIBaseController
{
    public function delivery_order_list(Request $request) {

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}

		$user_id = $request->user_id;

		$user = User::find($user_id);

		$delivery_order = DeliveryOrder::where('user_id',$user_id)->orderBy('id', 'desc')
				->where('approve',1)
				->get();

		$delivery_orders = DeliveryOrderResource::collection($delivery_order);

		return $this->sendSuccessResponse('data',$delivery_orders);
	}

// 	public function delivery_itemlist_details(Request $request){

// 		$validator = Validator::make($request->all(), [
// 			'user_id' => 'required',
// 			'delivery_order_id' => 'required',
// 		]);

// 		if ($validator->fails()) {

// 			return $this->sendFailResponse("Wrong Resource");
// 		}
// 		$user_id = $request->user_id;

// 		$user = User::find($user_id);

// 		$delivery_order = DeliveryOrder::find($request->delivery_order_id);

// 		$delivery_order_list = DeliveryOrderList::where('delivery_order_id',$delivery_order->id)->get();

// 		$delivery_order_lists = DeliveryOrderListResource::collection($delivery_order_list);

// 		return $this->sendSuccessResponse('data',$delivery_order_lists);

// 	}

	public function delivery_itemlist_details(Request $request){

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'delivery_order_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		$user_id = $request->user_id;

		$user = User::find($user_id);

		$delivery_order = DeliveryOrder::find($request->delivery_order_id);

		$delivery_order_list = DeliveryOrderList::where('delivery_order_id',$delivery_order->id)->get();
		$delivery_product_detail = [];
		foreach($delivery_order_list as $deli_list)
		{
			$product_detail = Product::find($deli_list->product_id);
			
			$brand_id = $product_detail->brand_id;
			$serial_number = $product_detail->serial_number;
			$model_number = $product_detail->model_number;
			$measuring_unit = $product_detail->measuring_unit;
			$brand_detail = Brand::find($brand_id);
			$brand_name = $brand_detail->name;
			$coo = $brand_detail->country_of_origin;
			$deli_product_detail = array(
					'delivery_order_id' => $deli_list->delivery_order_id,
					'stock_qty' => $deli_list->stock_qty,
					'product_id' => $product_detail->id,
					'product_name' => $product_detail->name,
					
					
					
					'brand_name' => $brand_name,
					'serial_number' => $serial_number,
					'model_number' => $model_number,
					'coo' => $coo,
					
				);
			array_push($delivery_product_detail,$deli_product_detail);


		}


		// $delivery_order_lists = DeliveryOrderListResource::collection($delivery_order_list);

		return $this->sendSuccessResponse('data',$delivery_product_detail);

	}

	public function delivery_order_accept(Request $request){
        
        $toShow_inventory = [];

		$validator = Validator::make($request->all(),[
			'user_id' => 'required',
			'delivery_order_id' => 'required',
		]);

		if($validator->fails()){

			return $this->sendFailResponse("Wrong Resource");

		}

		$user_id = $request->user_id;

		$delivery_order = DeliveryOrder::find($request->delivery_order_id);

		$delivery_order_list = DeliveryOrderList::where('delivery_order_id',$delivery_order->id)->get();

		$project = Project::find($delivery_order->project_id);

		foreach ($delivery_order_list as $item_list) {

			$product = Product::find($item_list->product_id);
			
			$site_inventory = SiteInventory::where('product_id',$product->id)->first();
			
			if(!empty($site_inventory->product_id) == $item_list->product_id ){
				$site_inventory->delivered_qty += $item_list->stock_qty;
				$site_inventory->received_date = date('Y-m-d');
				$site_inventory->save();
				array_push($toShow_inventory,$site_inventory);
				
			}elseif(empty($site_inventory->product_id)){
				$new_site_inventory = SiteInventory::create([
					'product_id' => $item_list->product_id,
					'model_number' => $item_list->product->model_number,
					'measuring_unit' => $item_list->product->measuring_unit,
					'name' => $item_list->product->name,
					'brand_name' => $item_list->product->brand_name,
					'delivered_qty' => $item_list->stock_qty,
					'location' => $project->location,
					'received_date' => date('Y-m-d'),
					'project_id' => $delivery_order->project_id,
					'phase_id' => $delivery_order->phase_id,
					'flag' => 1,	
				]);
				array_push($toShow_inventory,$new_site_inventory);
			}
			
			
			$product->reserved_qty = 0;
			$product->save();

		}
		$puchase_order = PurchaseOrder::find($delivery_order->purchase_order_id);
		$puchase_order->status = 1;
		$puchase_order->save();
		$delivery_order->status = 1;
		$delivery_order->save();

		$sale_order = SaleOrder::where('purchase_order_id',$delivery_order->purchase_order_id)->first();
		$sale_order->status = 1;
		/*$site_inventories = SiteInventory::where('project_id',$delivery_order->project_id)->where('phase_id',$delivery_order->phase_id)->get();*/
		return response()->json([
			'site_inventories' => $toShow_inventory
		]);

	}
}



