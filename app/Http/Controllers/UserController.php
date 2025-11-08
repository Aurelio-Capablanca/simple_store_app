<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UsersRequest;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // View Retrievals    
    public function index()
    {
        $stores = Store::all();
        return view("users", compact("stores"));
    }



    //Logical Operations
    public function create_users(UserRequest $request): RedirectResponse
    {
        User::create($request->validated());
        return redirect()->route("users.form")->with("success", "User Created");
    }

    public function update_users(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->validated());
        return redirect()->route("users.form")->with("success","User Updated");
    }

    public function delete_users($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route("users.form")->with("success","User Deleted");
    }

}
