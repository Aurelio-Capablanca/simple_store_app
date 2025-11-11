<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdatesRequest;
use App\Models\Store;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    // View Retrievals    
    public function index()
    {
        $stores = Store::all();
        $users = DB::table('users', 'usr')->
            select('name', 'email', 'str.store_name', 'usr.id')
            ->leftJoin('store as str', 'str.id_store', '=', 'usr.id_store')
            ->get();
        return view("users", compact("stores", 'users'));
    }

    public function edit_modal($id)
    {
        $user = DB::table('users', 'us')
            ->select('us.*', 'sr.store_name')
            ->leftJoin('store as sr', 'sr.id_store','=','us.id_store')
            ->where('us.id', $id)
            ->first();
        $stores = Store::all();
        return view('modals/modal-users', compact('user','stores'));
    }


    //Logical Operations
    public function create_users(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());
        return redirect()->route("users.form")->with("success", "User Created");
    }

    public function update_users(UserUpdatesRequest $request, $id)
    {        
        $user = User::find($id);
        $user->update($request->validated());
        return redirect()->route("users.form")->with("success", "User Updated");
    }

    public function delete_users($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route("users.form")->with("success", "User Deleted");
    }

}
