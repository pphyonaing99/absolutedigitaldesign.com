<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zone;
use App\Shelve;
use App\Product;
use App\SiteInventory;
use App\ProjectPhase;
use App\Defect;
use App\Brand;
use App\Supplier;
use App\Category;
use App\Project;
use App\User;
use App\Handtool;
use App\HandtoolAssign;
use App\HandtoolList;
use Illuminate\Support\Facades\Validator;

class ProductController extends APIBaseController
{
    public function zone(Request $request) {
        $zones = Zone::all();
        
        return view('Warehouse/MasterData/zone',compact('zones'));
    }
    public function ajaxStoreZone(Request $request){

    	$name = $request->name;
    	$description = $request->description;

    	$zone = Zone::create([
			'name' => $name,
			'description' => $description,
		]);


    	return $this->sendSuccessResponse('data',$zone);

    }

    //Shelve

    public function shelve($zone_id){

    	$shelves = Shelve::where('zone_id',$zone_id)->get();

    	return view('Warehouse/MasterData/shelve',compact('shelves'));

    }

    public function storeShelve(Request $request){

    	$zone_id = $request->zone_id;
    	$name = $request->shelve_name;
    	$description = $request->shelve_description;

    	$shelve = Shelve::create([
			'name' => $name,
			'description' => $description,
			'zone_id' => $zone_id,
		]);

        alert()->success('Successfully Added Shelve');
    	return redirect()->back();
    }
    
    public function shelveProductList(Request $request,$shelve_id){
        $shelve = Shelve::find($shelve_id);
        $shelve_id = $shelve->id;
        
        $products = Product::where('shelve_id',$shelve->id)->get();
        
        return view('Warehouse/MasterData/product',compact('products','shelve_id'));
    }
    
    public function getShelveList(Request $request){
        $zone = Zone::find($request->zone_id);
        $shelves = Shelve::where('zone_id',$zone->id)->get();
        
        return response()->json($shelves);
    }
    
    public function assignShelve(Request $request){
        $validator = Validator::make($request->all(), [
            'shelve_id' => 'required',
            'product_id' => 'required',
        ]);
        if($validator->fails()){
            alert()->warning('Please Fill all field!');
            return redirect()->back();
        }
        
        $product = Product::find($request->product_id);
        if(empty($product)){
            alert()->warning('Product not found!');
            return redirect()->back();
        }
        
        $product->shelve_id = $request->shelve_id;
        $product->save();
        
        alert()->success('Successfully Assigned Shelve for Product');
        return redirect()->back();
    }
    
    public function createProduct() {

		$brands = Brand::all();
		$categories = Category::all();

		return view('Warehouse/MasterData/create_product',compact('brands','categories'));
	}
    
    public function getDefectItemList(Request $request){
        $site_inventories = [];
        $defect_items = Defect::all();
                    
        $user = session()->get('user');
        
        $phases = ProjectPhase::where('user_id',$user->id)->get();

		foreach ($phases as $phase) {
			$site_inventory = SiteInventory::where('phase_id',$phase->id)->get();

			foreach ($site_inventory as $site) {
				array_push($site_inventories,$site);
			}
		}
                    
        return view('Manager/Product/defect',compact('defect_items','site_inventories'));
    }
    public function storeDefectItem(Request $request){
        $validator = Validator::make($request->all(), [
            'qty' => 'required',
            'defect_date' => 'required',
            'comment' => 'required',
            'inventory_id' => 'required'
        ]);
        if($validator->fails()){
            alert()->warning('Please Fill all field!');
            return redirect()->back();
        }
        
        $inventory = SiteInventory::find($request->inventory_id);
        if(empty($inventory)){
            alert()->warning('Inventory not found');
            return redirect()->back();
        }
        
        $product = Product::find($inventory->product_id);
        if(empty($product)){
            alert()->warning('Product not found');
            return redirect()->back();
        }
        $final_quantity = (int)$inventory->delivered_qty - (int)$request->qty;
        if($final_quantity < 0){
            alert()->warning('Defect item count is larger than the stock count');
            return redirect()->back();
        }else{
            $inventory->delivered_qty = $final_quantity;
            // $inventory->save();
            
            $defect_item = Defect::create([
                'qty' => $request->qty,
                'product_id' => $product->id,
                'user_id' => session()->get('user')->id,
                'comment' => $request->comment??"",
                'defect_date' => $request->defect_date
            ]);
            
            return redirect()->route('defect-list');
        }
       
    }
    public function handtoolList(){
        $handtools = Handtool::orderBy('id','desc')->get();
        $categories = Category::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $shelves = Shelve::all();
        $projects = Project::all();
        
        return view('Warehouse/MasterData/hand_tool',compact('handtools','categories','brands','suppliers','shelves','projects'));
    }
    
    public function assign(){
        $handtools = Handtool::all();
        $projects = Project::all();
        
        return view('Warehouse/MasterData/assign',compact('handtools','projects'));
    }
    
    public function storeHandTool(Request $request){
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'supplier_id' => 'required',
            'serial_number' => 'required',
            'brand_id' => 'required'
        ]);
        if($validator->fails()){
            alert()->warning('Please Fill all field!');
            return redirect()->back();
        }
        
        Handtool::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'supplier_id' => $request->supplier_id,
            'model' => $request->model,
            'serial_number' => $request->serial_number,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'purchase_date' => $request->purchase_date,
            'shelve_id' => $request->shelve_id,
            'description' => $request->description,
            'status' => 0,
        ]);
        
        alert()->success('Successfully Added Hand Tool');
        return redirect()->back();
    }
    
    public function assignHandTool(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'phase_id' => 'required'
        ]);
        if($validator->fails()){
            alert()->warning('Please Fill all field!');
            return redirect()->back();
        }
        
        $assign_handtool = HandtoolAssign::create([
            'phase_id' => intval($request->phase_id),
            'user_id' => intval($request->user_id),
            'handtool_list' => json_encode($request->handtool_id),
            'site_status' => 0,
            'status' => 0,
            'assigned_qty' => count($request->handtool_id),
        ]);
        
        foreach($request->handtool_id as $handtool_id){
            HandtoolList::create([
                'handtool_assign_id' => $assign_handtool->id,
                'user_id' => intval($request->user_id),
                'handtool_id' => intval($handtool_id),
                'assigned_date' => date('Y-m-d'),
                'status' => 0,
            ]);
        }
        
        alert()->success('Successfully Assigned Handtool');
        return redirect()->route('handtool');
    }
    public function returnHandtool(){
        $handtools = Handtool::orderBy('id','desc')->get();
        $handtool_assigns = HandtoolAssign::where('return_status',1)->get();
        $handtool_lists = HandtoolList::all();
        $categories = Category::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $shelves = Shelve::all();
        $projects = Project::all();
        
        return view('Warehouse/MasterData/return_handtool',compact('handtools','categories','brands','suppliers','shelves','projects','handtool_assigns','handtool_lists'));
    }
    public function acceptHandtool(Request $request){
        $handtool_assign = HandtoolAssign::find($request->handtool_assign_id);
        $handtool = Handtool::find($request->handtool_id);
        
        $handtool_list = HandtoolList::where('handtool_assign_id',$handtool_assign->id)
                ->where('handtool_id',$handtool->id)
                ->first();
                
        if(empty($handtool_list)) {
            return response()->json('Handtool List not found');
        }
        
        $handtool_list->status = 1;
        
        $handtool->status = 0;
        $handtool_assign->returned_qty += 1;
        if($handtool_assign->assigned_qty == $handtool_assign->returned_qty) {
            $handtool_assign->status = 1;
        }
        $handtool_list->save();
        $handtool_assign->save();
        $handtool->save();
        
        return response()->json('Successfully Accepted');
    }
    
    public function getSiteEngineer(Request $request){
        $phase = ProjectPhase::find($request->phase_id);
        
        $user = User::find($phase->user_id);
        
        return response()->json($user);
    }
}
