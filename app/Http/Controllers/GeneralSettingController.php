<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    public function general_setting(){
    	return view('general_setting');
    }
}