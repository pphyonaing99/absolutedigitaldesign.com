<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Supplier;
use App\Brand;

class SupplierController extends Controller
{
    public function supplier_list(){

    	$brands = Brand::all();

    	$suppliers = Supplier::all();

    	return view('ProcurementOfficer/Supplier/supplier_list',compact('suppliers','brands'));
    }
    public function ajaxSupplier(Request $request){

        $brands = $request->brands;
        
    	$supplier = Supplier::create([
    	    'email' => $request->email,
    		'name' => $request->name,
    		'phone' => $request->phone,
    		'address' => $request->address,
    	]);

        foreach ($brands as $brand) {
            $supplier->assignBrand($brand);
        }

    	$supplier_id = $supplier->id;
		$supplier_code = sprintf("%04s", $supplier_id);
		$supplier->supplier_code = $supplier_code;
		$supplier->save();

    	return response()->json('success');
    }
}
