<?php

namespace App\Http\Controllers;

use App\Http\Requests\RetailerRequest;
use App\Models\Retailer;
use Illuminate\Http\Request;

class RetailerController extends Controller
{
    //UI Retrievals
    public function index() {
        $retailers = Retailer::all();
        //dd($retailers);
        return view("retailer", compact("retailers"));
    }


    public function edit_modal($id){
        //dd($id); 
        $retailer = Retailer::find($id);
        return view("modals/modal-retailer", compact("retailer"));
    }

    //Logical Operations
    public function create_retailer(RetailerRequest $request){
        Retailer::create($request->validated());
        return redirect()->route("retailer.form")->with("success","Retailer Added");
    }

    public function update_retailer(RetailerRequest $request, $id){
        $retailer = Retailer::find($id);
        $retailer->update($request->validated());
        return redirect()->route("retailer.form")->with("success","Retailer Updated");
    }

    public function delete_retailer($id){
        $retailer = Retailer::find($id);
        $retailer->delete();
        return redirect()->route("retailer.form")->with("success","Retailer Deleted");
    }

}
