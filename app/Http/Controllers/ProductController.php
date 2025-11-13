<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function call_categories()
    {
        $rust_url = 'http://127.0.0.1:9091/api/get-categories';
        $token = $this->generate_token();

        $client = new \GuzzleHttp\Client();
        $response = $client->get($rust_url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return $data;
    }

    //UI retieval
    public function index()
    {
        $stores = DB::table('store', 'st')
            ->select('st.id_store', 'st.store_name')
            ->get();

        $categories_data = $this->call_categories();
        $categories = $categories_data['dataset'] ?? [];
        $retailers = DB::table('retailer', 'cat')
            ->select('id_retailer', 'retailer_company')
            ->get();
        $users = DB::table('users', 'usr')->
            select('name', 'email', 'str.store_name', 'usr.id')
            ->leftJoin('store as str', 'str.id_store', '=', 'usr.id_store')
            ->get();
        return view("product", compact("users", "stores", "retailers", "categories"));
    }




    //Logical operations

    public function load_products(Request $request)
    {
        $service_url = 'http://127.0.0.1:9091/api/load-products';
        $token = $this->generate_token();
        $client = new \GuzzleHttp\Client();
        $payload = $request->getContent();
        $response = $client->post($service_url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => $payload,
        ]);

        return response($response->getBody(), $response->getStatusCode())
            ->header('Content-Type', 'application/json');
    }


    public function call_jwt()
    {
        $rust_url = 'http://127.0.0.1:9091/api/test-identity';
        $token = $this->generate_token();

        $client = new \GuzzleHttp\Client();
        $response = $client->get($rust_url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);

        return response($response->getBody(), $response->getStatusCode())
            ->header('Content-Type', 'application/json');
    }




    public function generate_token()
    {
        $user = Auth::user();
        $payload = [
            'iss' => 'http://localhost',
            'sub' => $user->id,
            'exp' => time() + 3600,
            'iat' => time(),
        ];
        $secret = "791376c27ad90e5594339a004d26ef259e8faaba";
        $token = JWT::encode($payload, $secret, 'HS256');
        return $token;
    }



}
