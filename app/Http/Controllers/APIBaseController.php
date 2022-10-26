<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    public function sendSuccessResponse( $data_name = "data", $data = []){

    	$successStatus = 200;
    	
    	return response()->json([
    		"message" => "Successfull",
    		"status" => $successStatus,
    		$data_name => $data,
    	]);
    }

    public function sendFailResponse($message = ""){

    	$FailStatus = 422;
    	
    	return response()->json([
    		"status" => $FailStatus,
    		"message" => $message,
    	]);
    }
}
