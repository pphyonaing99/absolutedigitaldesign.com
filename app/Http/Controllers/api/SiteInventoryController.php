<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProjectPhase;
use App\SiteInventory;
use App\User;
use Illuminate\Support\Facades\Validator;

class SiteInventoryController extends Controller
{
    public function site_inventories(Request $request){
    	$site_inventories = [];
    	$validator = Validator::make($request->all(), [
			'user_id' => 'required',
		]);

		if ($validator->fails()) {

			return $this->sendFailResponse("Wrong User");
		}

		$user = User::find($request->user_id);

		$phases = ProjectPhase::where('user_id',$user->id)->get();

		foreach ($phases as $phase) {
			$site_inventory = SiteInventory::where('phase_id',$phase->id)->get();

			foreach ($site_inventory as $site) {
				array_push($site_inventories,$site);
			}
		}

		return response()->json([
			'site_inventories' => $site_inventories,
		]);

    }
}
