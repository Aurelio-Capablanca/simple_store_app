<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //UI retieval
    public function index(){
        $stores = Store::all();
        $users = DB::table('users', 'usr')->
            select('name', 'email', 'str.store_name', 'usr.id')
            ->leftJoin('store as str', 'str.id_store', '=', 'usr.id_store')
            ->get();
        return view("product",compact("users","stores"));
    }

    //Logical operations

}
