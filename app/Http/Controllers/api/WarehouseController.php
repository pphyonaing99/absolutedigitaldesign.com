<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\APIBaseController;
use App\Http\Resources\PurchaseOrderListResource;
use App\Item;
use App\PurchaseOrder;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends APIBaseController {

	public function store_item(Request $request) {

		$validator = Validator::make($request->all(), [
			'serial_number' => 'required',
			'name' => 'required',
			'request_qty' => 'required',
			'brand_name' => 'required',
			'reg_date' => 'required',
		]);

		if ($validator->fails()) {
			return $this->sendFailResponse();
		}
		$user_id = $request->id;

		$user = User::where('id', $user_id)->first();

		if ($user->hasRole('Warehouse Manager')) {

			$item = Item::create([
				'serial_number' => $request->serial_number,
				'name' => $request->name,
				'stock_qty' => $request->request_qty,
				'brand_name' => $request->brand_name,

			    'reg_date' => $request->reg_date,

			]);
			return $this->sendSuccessResponse('data', $user);

		} else {
			return $this->sendFailResponse();
		}
	}

	public function purchase_order_list(Request $request) {

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
		]);

		$user_id = $request->user_id;

		$user = User::where('id', $user_id)->first();

		$purchase_orders = PurchaseOrder::all();

		$purchase_order = PurchaseOrderListResource::collection($purchase_orders);

		return $this->sendSuccessResponse('order', $purchase_order);

	}

	public function delivery_order(Request $request) {

		$validator = Validator::make($request->all(), [
			'eta_date' => 'required',
		]);

		$id = $request->id;

		$eta_date = $request->eta_date;

		$purchase_orders = PurchaseOrder::find($id);

		$eta_date = date('Y-m-d', strtotime($eta_date));

		$purchase_orders->eta_date = $eta_date;

		$purchase_orders->site_status = 1;
		$purchase_orders->status = 1;

		$purchase_orders->save();

		return $this->sendSuccessResponse('purchase_orders', $purchase_orders);
	}

	public function Purchase_Order_Create(Request $request) {

		$validator = Validator::make($request->all(), [
			'user_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}

		$item = Item::all();

		return $this->sendSuccessResponse('item', $item);
	}

	public function store_purchase_order(Request $request) {

		$validator = Validator::make($request->all(), [
			'request_date' => 'required',
			'item_id' => 'required',
			'request_qty' => 'required',
			'eta_date' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(['error', $validator->errors()]);
		}
		$item_id = $request->item_id;
		$purchase_orders = PurchaseOrder::create([
			'request_date' => $request->request_date,
			'item_id' => $item_id,
			'request_qty' => $request->request_qty,
			'eta_date' => $request->eta_date,
			'status' => 0,
		]);
		$todaydate = date('d');

		$order_code = "PO" . $todaydate . sprintf('%04s', $purchase_orders->id);

		$purchase_orders->order_code = $order_code;
		$purchase_orders->warehouse_status = 0;
		$purchase_orders->save();

		return $this->sendSuccessResponse('data', $purchase_orders);
	}
}
