<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    //UI Retrievals
    public function index(){
        $stores = DB::table('store','st')
        ->select('st.id_store','st.store_name', 'st.store_number','st.total_capital','l.location_place','l.id_location')
        ->join('location as l' ,'st.store_location','=','l.id_location')
        ->get();
        $locations =DB::table('location','l')
        ->select('id_location','location_place')
        ->get();
        return view("stores",compact("stores","locations"));
    }

    public function edit_modal($id){
        $store = Store::find($id);        
        $locations =DB::table('location','l')
        ->select('id_location','location_place')
        ->get();
        return view("modals/modal-store",compact("store","locations"));
    }

    //Logical Operations
    public function create_stores(StoreRequest $request){
        Store::create($request->validated());
        return redirect()->route("stores.form")->with("success","Store Created");
    }

    public function update_store(StoreRequest $request, $id){
        $store = Store::find($id);
        $store->update($request->validated());
        return redirect()->route("stores.form")->with("success","Store Updated");
    }

    public function delete_store($id){
        $store = Store::find($id);
        $store->delete();
        return redirect()->route("stores.form")->with("success","Store Deleted");
    }

}
