<?php

namespace App\Http\Controllers\api;

use App\Role;
use App\User;
use App\ProjectPhase;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\APIBaseController;

class LoginController extends APIBaseController {
	public function login(Request $request) {

		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required',
		]);

		if ($validator->fails()) {
			return response()->json(['error', $validator->fails()]);
		}

		$email = $request->email;

		$password = $request->password;

		$user = User::where('email', $email)->first();

		if (empty($user)) {

			return $this->sendFailResponse("Wrong email!");
		} elseif (!\Hash::check($password, $user->password)) {

			return $this->sendFailResponse("Wrong password!!!");

		} else {

			$user = User::where('email', $email)->first();

			$id = $user->id;
			$email = $user->email;
			$name = $user->name;

			// dd($id);

			// $user_role = Role::where('user_id',$id)->first();

			// $token=$user->createToken('Inventory')->accessToken;

			if ($user->hasRole('Site Supervisor')) {
			    
			    $user_phase = ProjectPhase::where('user_id',$id)->first();
			    $phase_id = $user_phase->id;

				return response()->json([
					'user' => [
						'id' => $user->id,
						'email' => $user->email,
						'name' => $user->name,

                        'work_site_id' => $user->work_site_id,
                        'phase_id' => $phase_id,
						//'token'=>$token,

					],
					'success' => 'true',
					'message' => 'Successfully Login',
				]);

			} elseif ($user->hasRole('Warehouse Supervisor')) {

				return response()->json([
					'user' => [
						'id' => $user->id,
						'email' => $user->email,
						'name' => $user->name,
                        'work_site_id' => $user->work_site_id,
					//	'token'=>$token,

					]
				]);
			}
		}
	}
}