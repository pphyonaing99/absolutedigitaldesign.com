<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\APIBaseController;
use App\Product;
use App\ExtraUnit;

class ProductController extends APIBaseController

{
    public function product_store(Request $request){
    	$extra_units = json_decode($request->extra_unit);

		return response()->json(is_array($extra_units));
		/*$validator = Validator::make($request->all(), [
			'model_number' => 'required',
			'name' => 'required',
			'stock_qty' => 'required',
			'brand_name' => 'required',
			'reg_date' => 'required',
			'location' => 'required',
			'measuring_unit' => 'required',
			'reorder_quantity' => 'required',
			'purchase_price' => 'required',
			'retail_price' => 'required',
			'wholesale_price' => 'required',
		]);

		if ($validator->fails()) {
			alert()->info("Please Fill all Field!");
		}*/

		/*$product = Product::create([
			'brand_id' => $request->brand_id,
			'model_number' => $request->model_number,
			'name' => $request->name,
			'stock_qty' => $request->stock_qty,
			'brand_name' => $request->brand_name,
			'reg_date' => $request->reg_date,
			'location' => $request->location,
			'measuring_unit' => $request->measuring_unit,
			'reorder_qty' => $request->reorder_qty,
			'purchase_price' => $request->purchase_price.'-'.$request->purchase_price_currency,
			'retail_price' => $request->retail_price.'-'.$request->retail_price_currency,
			'wholesale_price' => $request->wholesale_price.'-'.$request->wholesale_price_currency,
			'discount_flag' => $request->discount_flag,
			'discount_type' => $request->discount_type,
		]);*/



		foreach ($extra_units as $extra) {
				// return response()->json(is_array($extra));
		return response()->json($extra);
					/*$extra_unit = ExtraUnit::create([
					'product_id' => $product->id,
					'name' => $extras->extra_measuring_unit,
					'basic_unit_qty' => $extras->basic_unit_qty,
					'stock_qty' => $extras->extra_stock_qty,
					'reorder_qty' => $extras->extra_reorder_qty,
					'retail_price' => $extras->extra_retail_price.'-'.$extras->extra_wholesale_price_currency,
					'wholesale_price' => $extras->extra_retail_price.'-'.$extras->extra_wholesale_price_currency,
					'discount_flag' => "on",
					'discount_type' => $request->discount_type,
				]);*/

		}

		return response()->json([
			'product' => $product,
			'extra_unit' => $extra_unit,
		]);
    }
}
