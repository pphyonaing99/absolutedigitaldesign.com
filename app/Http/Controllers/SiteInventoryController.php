<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SiteInventory;
use App\Project;
use App\ProjectPhase;

class SiteInventoryController extends Controller
{
    public function pm_site_inventory(){

    	$site_inventories = SiteInventory::orderBy('id','desc')->get();

    	$projects = Project::all();

    	return view('Manager/SiteInventory/site_inventories',compact('site_inventories','projects'));
    }

    public function getProjectSiteInventory(Request $request){

    	$phases = ProjectPhase::where('project_id',$request->id)->get();

    	$site_inventories = SiteInventory::where('project_id',$request->id)->get();

    	return response()->json([
    		'phases' => $phases,
    		'site_inventories' => $site_inventories,
    	]);

    }
    public function getPhaseSiteInventory(Request $request){

    	$phase = ProjectPhase::find($request->id);

    	$project = Project::find($phase->project_id);

    	$site_inventories = SiteInventory::where('project_id',$project->id)
    				->where('phase_id',$phase->id)
    				->get();

    	return response()->json($site_inventories);

    }
}