<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialIssue;
use App\MaterialIssueList;
use App\Employee;
use App\Product;
use App\Project;
use App\RegionalInventory;
use App\RegionalWarehouse;
use Illuminate\Support\Facades\Validator;

class RegionalWarehouseController extends Controller
{
    public function storeRegional(Request $request){
        $validator = Validator::make($request->all(), [
            'warehouse_name' => 'required',
            'region' => 'required',
            'country' => 'required',
            'location_address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('RegionalWarehouse')
                        ->withErrors($validator)
                        ->withInput();
        }

        $regional_warehouse = RegionalWarehouse::create([
            'warehouse_name' => $request->warehouse_name,
            'region' => $request->region,
            'country' => $request->country,
            'location_address' => $request->location_address,
            'area' => $request->area,
            'capacity' => $request->capacity,
            'employee_id' => $request->employee_id,
            'project_id' => implode(',',$request->project_id),
        ]);

        foreach($request->project_id as $project_id){
            $project = Project::find($project_id);

            if($project->regional_warehouse_id != null){
                alert()->warning('Project is assign in other regional warehouse!');
                return redirect()->back();
            }else{
                $project->regional_warehouse_id = $regional_warehouse->id;
                $project->save();
            }
        }

        return redirect()->route('RegionalWarehouse');
    }

    public function WarehouseTransferOrder(){

    	$user = session()->get('user');
    	$employee = Employee::where('user_id',$user->id)->first();
        // dd($employee->id);
    	$regional_warehouse = RegionalWarehouse::where('employee_id',$employee->id)->first();
        // dd($regional_warehouse->id);
    	$material_issues = MaterialIssue::orderBy('status','desc')
    			->where('regional_warehouse_id' , $regional_warehouse->id)
                ->where('approve',1)
    			->get();

    	$material_issue_list = MaterialIssueList::all();

    	return view('Warehouse/RegionalWarehouse/warehouse_transfer',compact('material_issues','material_issue_list'));

    }

    public function AcceptWarehouseTransfer(Request $request , $material_issue_id){

    	$material_issue = MaterialIssue::find($material_issue_id);

    	$material_issue->warehouse_transfer_status = 1;
        $material_issue->save();

        $user = session()->get('user');
    	$employee = Employee::where('user_id',$user->id)->first();
    	$regional_warehouse = RegionalWarehouse::where('employee_id',$employee->id)->first();

        foreach ($material_issue->item_list as $key => $value) {
        	

            $product = Product::find($value->id);

            if ($product->id == $value->id) {
                
                $product->reserved_qty -= $value->qty;
                $product->save();

            }

            $regional_inventory = RegionalInventory::where('regional_warehouse_id' , $regional_warehouse->id)
                        ->where('product_id' , $product->id)
                        ->get();

            if (count($regional_inventory) == 0) {
                
                $regional_inventory = RegionalInventory::create([

                    'product_id' => $product->id,
                    'regional_warehouse_id' => $material_issue->regional_warehouse_id,
                    'model_number' => $product->model_number,
                    'measuring_unit' => $product->measuring_unit,
                    'name' => $product->name,
                    'transfer_qty' => $value->qty,
                    'location' => $product->location,
                    'received_date' => date("Y-m-d"),
                    'reserved_qty' => 0,
                    'project_id' => $material_issue->project_id,
                    'phase_id' => $material_issue->phase_id,
                    'flag' => 0,

                ]);
            }else{
                
                foreach ($regional_inventory as $inventory) {
                    if ($inventory->product_id == $value->id) {
                        $inventory->transfer_qty += $value->qty;
                        $inventory->save();
                    }
                }

            }
                

        }
        alert()->success('Successfully Accepted Transfer');
        return redirect()->back();

    }
    
    public function regionalInventory(Request $request, $regional_id) {
        $regional_inventories = RegionalInventory::where('regional_warehouse_id',$regional_id)->get();
        
        return view('Warehouse/RegionalWarehouse/regional_inventory',compact('regional_inventories')); 
    }
    
    public function regionalInventories(Request $request) {
        
        $user = session()->get('user');
        
        $employee = Employee::where('user_id',$user->id)->first();
        
        $regional_warehouse = RegionalWarehouse::where('employee_id',$employee->id)->first();
        
        $regional_inventories = RegionalInventory::where('regional_warehouse_id',$regional_warehouse->id)->get();
        
        return view('Warehouse/RegionalWarehouse/regional_inventory',compact('regional_inventories')); 
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
