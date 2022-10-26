<?php

namespace App\Http\Controllers\api;
use App\Brand;
use App\Category;
use App\Handtool;
use App\HandtoolList;
use App\HandtoolAssign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIBaseController;

class HandtoolController extends APIBaseController
{
    public function handtoolList(Request $request){
        
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'phase_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
        
        $user_id = $request->user_id;
		$phase_id = $request->phase_id;
		$handtools = HandtoolAssign::where('user_id',$user_id)->where('phase_id',$phase_id)->first();
		$handtool_lists = HandtoolList::where('handtool_assign_id',$handtools->id)
		

                    ->where('return_status',0)
                    ->get();
		
	            
        // if(!empty($handtool_lists)) {
        //     foreach($handtool_lists as $list){
        //         $handtool = Handtool::find($list->handtool_id);
        //         $list['handtool_name'] = $handtool->name;
        //     }
        // }
		$handtool_detail = [];
		foreach($handtool_lists as $hand_list)
		{
			$hand_detail = Handtool::find($hand_list->handtool_id);
			$brand_detail = Brand::find($hand_detail->brand_id)->name;
			$cate_detail = Category::find($hand_detail->category_id)->name;
			$serial_number = $hand_detail->serial_number;
			$model = $hand_detail->model;
			$handTool_detail = array(
					'handtool_assign_id' => $hand_list->handtool_assign_id,
					'user_id' => $hand_list->user_id,
					'handtool_id' => $hand_detail->id,
					'handtool_name' => $hand_detail->name,
					'handtool_category' => $cate_detail,
					'handtool_serial_no' => $serial_number,
					'handtool_brand' => $brand_detail,
					'handtool_model' => $model,
					'assigned_date' => $hand_list->assigned_date,
					'return_date' => $hand_list->return_date,
					'site_status' => $hand_list->site_status,
					'return_status' => $hand_list->return_status,
				);
			array_push($handtool_detail,$handTool_detail);

		}

        return $this->sendSuccessResponse('data',$handtool_detail);
    }

	
    public function assignDetail(Request $request){
        
        $validator = Validator::make($request->all(), [
			'assign_handtool_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
        
        $user_id = $request->user_id;
        $handtool_lists = HandtoolList::where('assign_handtool_id',$request->assign_handtool_id)
                    ->get();
                    
        if(!empty($handtool_lists)) {
            foreach($handtool_lists as $list){
                $handtool = Handtool::find($list->handtool_id);
                $list['handtool_name'] = $handtool->name;
            }
        }
                    
        return $this->sendSuccessResponse('data',$handtool_lists);
    }
    public function assignHandtoolList(Request $request){
        
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'phase_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
        
		$user_id = $request->user_id;
		$phase_id = $request->phase_id;
		$handtools = HandtoolAssign::where('user_id',$user_id)->where('phase_id',$phase_id)->first();
		$assign_date = $handtools->created_at->format('Y-m-d');
        //  dd($assign_date); 
		$list = [];
		$hand_detail = array(

					'id' => $handtools->id,

					'phase_id' => $handtools->phase_id,
					'user_id' => $handtools->user_id,
					'handtool_list' => $handtools->handtool_list,
					'site_status' => $handtools->site_status,
					'assign_qty' => $handtools->assigned_qty,
					'accept_qty' => $handtools->accept_qty,
					'return_qty' => $handtools->returned_qty,
					'return_status' => $handtools->return_status,
					'return_date' => $handtools->return_date,


			'assign_date' => $assign_date,

			
		);
	array_push($list,$hand_detail);

        return $this->sendSuccessResponse('data',$list);
    }
//     public function assignHandtoolList(Request $request){
        
//         $validator = Validator::make($request->all(), [
// 			'user_id' => 'required',
// 		]);

// 		if ($validator->fails()) {

// 			return $this->sendFailResponse("Wrong Resource");
// 		}
        
//         $user_id = $request->user_id;
//         $handtool_lists = HandtoolAssign::where('user_id',$user_id)
//                     ->where('return_status',0)
//                     ->get();
                    
//         return $this->sendSuccessResponse('data',$handtool_lists);
//     }
    
     public function acceptHandtool(Request $request){
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			// 'phase_id' => 'required',
			'handtool_assign_id' => 'required',
			'handtool_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}

		$user_id = $request->user_id;
		// $phase_id = $request->phase_id;
		
		$handtool_assign = HandtoolAssign::where('user_id',$user_id)->where('id',$request->handtool_assign_id)->first();
		
		if(empty($handtool_assign)){
		    return $this->sendFailResponse('Handtool Assign not found');
		}
		
		$handtool_list = HandtoolList::where('handtool_assign_id',$request->handtool_assign_id)
		            ->where('handtool_id',$request->handtool_id)
		            ->first();
		            
		$handtool_list->site_status = 1;
		
		$handtool_assign->accept_qty += 1;
        if($handtool_assign->assigned_qty == $handtool_assign->accept_qty) {
            $handtool_assign->site_status = 1;
        }
        
        $handtool_list->save();
        $handtool_assign->save();
		
		return response()->json([
		   'status' => 201,
		   'message' => 'Successfully Accepted',
		   'data' => $handtool_assign
		   ]); 
		
    }
    
    public function returnHandtool(Request $request){
        $validator = Validator::make($request->all(), [
			'user_id' => 'required',
			'handtool_assign_id' => 'required',
			'handtool_id' => 'required',
			'return_date' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong Resource");
		}
		$user_id = $request->user_id;
		$handtool_assign = HandtoolAssign::where('user_id',$user_id)->where('id',$request->handtool_assign_id)->first();
		
		if(empty($handtool_assign)){
		    return $this->sendFailResponse('Handtool Assign not found');
		}

		$handtool_list = HandtoolList::where('handtool_assign_id',$request->handtool_assign_id)
		->where('handtool_id',$request->handtool_id)
		->first();
		$handtool_list->return_status = 1;
		$handtool_list->return_date = $request->return_date;
		$handtool_list->site_status = 1;
		// $handtool_assign->return_date = $request->return_date;
		// $handtool_assign->return_status = 1;
		$handtool_assign->returned_qty += 1;
		
		
		// foreach($request->handtool_lists as $handtool){
		//     $handtool_list = HandtoolList::find($handtool['id']);
		//     if($handtool_list->site_status == 0){
		//         return $this->sendFailResponse($handtool_list->handtool->name.' is not accepted');
		//     }else{
		//         $handtool_list->return_date = $request->return_date;
		//         $handtool_list->return_status = 1;
		        
		//     }
		// }
		if($handtool_assign->returned_qty == $handtool_assign->accept_qty) {
			$handtool_assign->return_date = $request->return_date;
            $handtool_assign->return_status = 1;
        }
		$handtool_assign->save();
		$handtool_list->save();
		
		return response()->json([
		   'status' => 201,
		   'message' => 'Successfully Returned',
		   'data' => $handtool_assign
		]); 
    }
    
//     public function returnHandtool(Request $request){
//         $validator = Validator::make($request->all(), [
// 			'handtool_assign_id' => 'required',
// 			'return_date' => 'required',
// 		]);

// 		if ($validator->fails()) {

// 			return $this->sendFailResponse("Wrong Resource");
// 		}
		
// 		$handtool_assign = HandtoolAssign::find($request->handtool_assign_id);
		
// 		if(empty($handtool_assign)){
// 		    return $this->sendFailResponse('Handtool Assign not found');
// 		}
		
// 		$handtool_assign->return_date = $request->return_date;
// 		$handtool_assign->return_status = 1;
		
// 		foreach($request->handtool_lists as $handtool){
// 		    $handtool_list = HandtoolList::find($handtool['id']);
// 		    if($handtool_list->site_status == 0){
// 		        return $this->sendFailResponse($handtool_list->handtool->name.' is not accepted');
// 		    }else{
// 		        $handtool_list->return_date = $request->return_date;
// 		        $handtool_list->return_status = 1;
		        
// 		    }
// 		}
// 		$handtool_assign->save();
// 		$handtool_list->save();
		
// 		return response()->json([
// 		   'status' => 201,
// 		   'message' => 'Successfully Returned',
// 		   'data' => $handtool_assign
// 		]); 
//     }
}
