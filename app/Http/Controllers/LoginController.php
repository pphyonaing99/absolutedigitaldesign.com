<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Role;
use App\User;
use App\FormList;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller {

	public function userlogin(Request $request) {

		if (Session::has('user')) {
			$all_form = FormList::all();
				$request->session()->put('formlistall',$all_form);
			
			if ($request->session()->get('user')->hasRole('Super Admin')) {
				$all_form = FormList::all();
				$request->session()->put('formlistall',$all_form);
				return view('master');

			} elseif ($request->session()->get('user')->hasRole('Project Manager')) {
				
				return redirect()->route('category_list');
			} elseif ($request->session()->get('user')->hasRole('Warehouse Supervisor')) {
				return redirect()->route('warehouse_sale_orders');
			} elseif ($request->session()->get('user')->hasRole('Sales')) {
				return redirect()->route('sale_purchase_order');
			} elseif ($request->session()->get('user')->hasRole('Procurement Officer')) {
				return redirect()->route('procurement_purchase_request_list');
			} elseif ($request->session()->get('user')->hasRole('Regional Warehouse')) {
				// return redirect()->route('WarehouseTransferOrder');
				// return redirect()->route('waretransfer_list');
				return redirect()->route('waretransfer_list');
				
			}elseif($request->session()->get('user')->hasRole('Sale Supervisor')) {
				return redirect()->route('waretransfer_list');

			}

		} else {

			return view('login');

		}

	}

	public function loginprocess(Request $request) {

		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required',
		]);

		if ($validator->fails()) {
			alert()->error("something Wrong");
			return redirect()->back();
		}

		$email = $request->email;

		$password = $request->password;

		$user = User::where('email', $email)->first();

		if (empty($user)) {

			alert()->error("Something Wrong");
			return redirect()->back();
		} elseif (!\Hash::check($password, $user->password)) {
			alert()->error("Something Wrong");
			return redirect()->back();

		} else {
			session()->put('user', $user);

			if ($user->hasRole('Super Admin')) {
				alert()->success("Login");
				return redirect()->route('general_setting');

			}elseif ($user->hasRole('Project Manager')) {
				alert()->success("Login");
				$user_id = $request->session()->get('user')->id;
				$role_id = DB::table('role_user')->where('user_id',$user_id)->first();
				$all_form = FormList::all();
				$request->session()->put('formlistall',$all_form);
				// dd($role_id->role_id);
				$dothischeck = FormList::where('check_by',$role_id->role_id)->get();
				// dd($dothischeck);
				// dd($dothischeck);
				$dothisprepare = FormList::where('prepare_by',$role_id->role_id)->get();
				// dd($dothisprepare);
				$dothisapprove = FormList::where('approve_by',$role_id->role_id)->get();
				
				$request->session()->put('formlist_check',$dothischeck);
				$request->session()->put('formlist_approve',$dothisapprove);
				$request->session()->put('formlist_prepare',$dothisprepare);
				return redirect()->route('category_list');

			} elseif ($user->hasRole('Warehouse Supervisor')) {
				$user_id = $request->session()->get('user')->id;
				$role_id = DB::table('role_user')->where('user_id',$user_id)->first();
				$all_form = FormList::all();
				$request->session()->put('formlistall',$all_form);
				// dd($role_id->role_id);
				$dothischeck = FormList::where('check_by',$role_id->role_id)->get();
				// dd($dothischeck);
				// dd($dothischeck);
				$dothisprepare = FormList::where('prepare_by',$role_id->role_id)->get();
				// dd($dothisprepare);
				$dothisapprove = FormList::where('approve_by',$role_id->role_id)->get();
				$request->session()->put('formlist_check',$dothischeck);
				$request->session()->put('formlist_approve',$dothisapprove);
				$request->session()->put('formlist_prepare',$dothisprepare);
				return redirect()->route('warehouse_sale_orders');
			} elseif ($user->hasRole('Sales')) {

				return redirect()->route('customer');
			} elseif ($user->hasRole('Procurement Officer')) {
				$user_id = $request->session()->get('user')->id;
				$role_id = DB::table('role_user')->where('user_id',$user_id)->first();
				$all_form = FormList::all();
				
				$formallarr = [];
				foreach($all_form as $allfo)
				{
					array_push($formallarr,$allfo->prepare_by);
				}
				$request->session()->put('formlistall',$formallarr);
				// dd($role_id->role_id);
				$dothischeck = FormList::where('check_by',$role_id->role_id)->get();
				// dd($dothischeck);
				// dd($dothischeck);
				$prearr = [];
				$dothisprepare = FormList::where('prepare_by',$role_id->role_id)->get();
				// dd($dothisprepare);
				foreach($dothisprepare as $dopre)
				{
					array_push($prearr,$dopre->prepare_by);
				}
				// dd($prearr);
				$dothisapprove = FormList::where('approve_by',$role_id->role_id)->get();
				$request->session()->put('formlist_check',$dothischeck);
				$request->session()->put('formlist_approve',$dothisapprove);
				$request->session()->put('formlist_prepare',$dothisprepare);
				return redirect()->route('procurement_purchase_request_list');
			}elseif ($user->hasRole('Regional Warehouse')) {
				$user_id = $request->session()->get('user')->id;
				$reg_id = $request->session()->get('user')->regional_id;
				// dd($reg_id);
				$request->session()->put('regional_id',$reg_id);
				$role_id = DB::table('role_user')->where('user_id',$user_id)->first();
				$all_form = FormList::all();
				$request->session()->put('formlistall',$all_form);
				// dd($role_id->role_id);
				$dothischeck = FormList::where('check_by',$role_id->role_id)->get();
				// dd($dothischeck);
				// dd($dothischeck);
				$dothisprepare = FormList::where('prepare_by',$role_id->role_id)->get();
				// dd($dothisprepare);
				$dothisapprove = FormList::where('approve_by',$role_id->role_id)->get();
				$request->session()->put('formlist_check',$dothischeck);
				$request->session()->put('formlist_approve',$dothisapprove);
				$request->session()->put('formlist_prepare',$dothisprepare);
				return redirect()->route('waretransfer_list_reg');
				// return redirect()->route('WarehouseTransferOrder');
			}elseif ($user->hasRole('Site Supervisor')) {

				return redirect()->route('report_list');
			}elseif ($user->hasRole('Sale Supervisor')){

				return redirect()->route('customer');

			}
		}
	}

	public function logoutprocess(Request $request) {

		Auth::logout();
		
		Session::flush();

		alert()->success('Successfully Logout!')->autoclose(2000);


		return redirect()->route('userlogin');
	}
}