<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //UI retieval
    public function index()
    {
        $stores = Store::all();
        $users = DB::table('users', 'usr')->
            select('name', 'email', 'str.store_name', 'usr.id')
            ->leftJoin('store as str', 'str.id_store', '=', 'usr.id_store')
            ->get();
        $jwt = $this->generate_token();
        return view("product", compact("users", "stores","jwt"));
    }

    //Logical operations

    public function generate_token()
    {
        $user = Auth::user();
        $payload = [
            'sub' => $user->id,
            'exp' => time() + 3600,
        ];
        return JWT::encode($payload, 'MGACAQAwEAYHKoZIzj0CAQYFK4EEACMESTBHAgEBBEIBGV7Ryk5PYpRLoFh+0f3KU7aS1bxmUy4QDTA7jfFyF6NkVF9mjXToZ9tSVFsPaOX79r86zZSwOihlAzQmEriPA4Q=', 'EC512');
    }



}
