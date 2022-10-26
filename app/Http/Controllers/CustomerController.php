<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Project;
use App\Customer;
use App\Document;

class CustomerController extends Controller
{
    public function customer(Request $request){

        $projects = Project::all();

        $customers = Customer::all();

        return view('Sale/Customer/customer',compact('projects','customers'));

    }

    public function storeCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'business_type' => 'required',
            'address' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'website' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('customer')
                        ->withErrors($validator)
                        ->withInput();
        }

        $customer = Customer::create([
            'company_name' => $request->company_name,
            'business_type' => $request->business_type,
            'address' => $request->address,
            'email' => $request->email,
            'website' => $request->website,
            'contact_person_name' => $request->contact_person_name,
            'contact_number' => $request->contact_number,
            // 'project_id' => implode(',',$request->project_id),
        ]);

        // foreach($request->project_id as $project_id){
        //     $project = Project::find($project_id);

        //     if($project->customer_id != null){
        //         alert()->warning('Project is assign in other Customer!');
        //         return redirect()->back();
        //     }else{
        //         $project->customer_id = $customer->id;
        //         $project->save();
        //     }
        // }
        alert()->success('Successfully created Customer!');
        return redirect()->route('customer');
    }

    public function document(){

        $documents = Document::all();

        $projects = Project::all();

        return view('Sale/Document/document',compact('documents','projects'));
    }

    public function storeDocument(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'project_id' => 'required',
            'phase_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('document')
                        ->withErrors($validator)
                        ->withInput();
        }

        $document = Document::create([
            'name' => $request->name,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'phase_id' => $request->phase_id,
        ]);

        alert()->success('Successfully created Document!');
        return redirect()->route('document');
    }
}
