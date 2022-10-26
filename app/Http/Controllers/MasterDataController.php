<?php

namespace App\Http\Controllers;

use App\Brand;
use App\User;
use App\Project;
use App\Category;
use App\Employee;
use App\Supplier;
use App\SubCategory;
use App\DiscountType;
use Illuminate\Support\Str;
use App\RegionalWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIBaseController;

class MasterDataController extends APIBaseController
{

    //Dicount Type
    public function discount_type(){
        $discount_types = DiscountType::all();

        return view('Manager/discount_type',compact('discount_types'));
    }
    public function ajaxDiscountType(Request $request){

        DiscountType::create([
            'name' => $request->name,
            'description' => $request->description,
            'discount_percent' => $request->discount_percent,
        ]);

        return response()->json("Success");
    }

	//category
    public function category_list(){

    	$categories = Category::all();

    	$count = count($categories);

    	return view('Warehouse/MasterData/category_list',compact('categories','count'));
    }
    public function ajaxCategory(Request $request){

    	$name = $request->name;
    	$description = $request->description;
    	$measuring_unit = $request->measuring_unit;

    	$category = Category::create([
			'name' => $name,
			'description' => $description,
			'measuring_unit' => $measuring_unit,
		]);


    	return $this->sendSuccessResponse('data',$category);

    }

    //Sub Category

    public function subcategory_list(){

    	$categories = Category::all();

    	$subcategories = SubCategory::all();

    	return view('Warehouse/MasterData/subcategory_list',compact('subcategories','categories'));

    }

    public function ajaxSubCategory(Request $request){

    	$category_id = $request->category_id;
    	$name = $request->name;
    	$description = $request->description;

    	$subcategory = SubCategory::create([
			'name' => $name,
			'description' => $description,
			'category_id' => $category_id,
		]);


    	return $this->sendSuccessResponse('data',$subcategory);
    }

    //Brand
    public function brand_list(){

    	$categories = Category::all();

    	$brands = Brand::all();

    	$suppliers = Supplier::all();

    	return view('Warehouse/MasterData/brand_list',compact('brands','categories','suppliers'));

    }

    public function getSubCategory(Request $request){

    	$subcategories = SubCategory::where('category_id',$request->category_id)->get();

    	return response()->json([
    		'subcategories' => $subcategories,
    	]);

    }
    public function store_regional_ware(Request $request)
    {
        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'warehouse_name' => 'required',
        //     'region' => 'required',
        //     'country' => 'required',
        //     'location_address' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return redirect('RegionalWarehouse')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

        if ($request->hasfile('photo')) {

			$photo = $request->file('photo');
			$name = $photo->getClientOriginalName();
			$photo->move(public_path() . '/image/', $name);
			$photo = $name;
		}

		$projectID = json_encode($request->proj);

		$user = User::create([
			'name' => $request->ware_name,
			'email' => $request->email,
			'password' => \Hash::make($request->password),
			'remember' => Str::random(60),
			// 'work_site_id' => 2,
			'work_site_id' => $projectID,
            

		]);

        $employee = Employee::create([
			'name' => $request->ware_name,
			'address' => $request->address,
			// 'phone' => $request->phone,
			'photo' => $photo,
			// 'employed_date' => $request->employed_date,
			// 'salary' => $request->salary,
			'user_id' => $user->id,
			'role' => 7,
		]);

        $user->assignRole(7);
		// dd("hello");
		$employee_code = "EPY" . sprintf("%04s", $employee->id);
		$employee->employee_code = $employee_code;
		$employee->save();

        $regional_warehouse = RegionalWarehouse::create([
            'warehouse_name' => $request->ware_name,
            'region' => $request->region,
            'country' => $request->country,
            'location_address' => $request->address,
            'area' => $request->area,
            'employee_id' => $employee->id,
            'photo' => $photo,
            
        ]);
        $user->regional_id = $regional_warehouse->id;
        $user->save();
        // dd($request->proj);
        foreach($request->proj as $project){
            // dd($project);
            $regional_warehouse->projects()->attach($project);
        }
        // dd("what");
        alert()->success("Successfully Store RegionalWarehouse");
        return redirect()->route('RegionalWarehouse');
    }
    public function ajaxStoreBrand(Request $request){

        $subcategories = $request->sub_category;
        $suppliers = $request->suppliers;        

    	$brands = Brand::create([
    		'category_id' => $request->category_id,
    		'name' => $request->name,
    		'description' => $request->description,
    		'country_of_origin' => $request->country_of_origin,
    	]);

        foreach ($subcategories as $sub) {
            $brands->assignSubCategory($sub);
        }
        // error
        foreach ($suppliers as $supplier) {
            $brands->assignSupplier($supplier);
        }
        //

    	return response()->json($brands);
    }

    public function create_regional_ware()
    {
        $projects = Project::all();
        return view('Warehouse/RegionalWarehouse/add_regional_warehouse',compact('projects'));
    }

    public function RegionalWarehouse(Request $request){

        $employees = Employee::all();

        $projects = Project::all();

        $regional_warehouses = RegionalWarehouse::all();

        return view('Warehouse/RegionalWarehouse/regional_warehouse',compact('employees','projects','regional_warehouses'));

    }

}
