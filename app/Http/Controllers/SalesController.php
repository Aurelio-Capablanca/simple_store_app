<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;

class SalesController extends Controller
{
    public function index()
    {
        $products =  DB::table('product', 'p')
            ->select('p.id_product', 'p.product_name')
            ->get();
        $stores =  DB::table('store', 's')
            ->select('s.id_store', 's.store_name')
            ->get();
        return view("sales", compact("products","stores"));
    }

    // Logical

    public function do_sell(Request $request)
    {
        $service_url = 'http://127.0.0.1:9091/api/do-sale';
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

    public function call_single_product($id)
    {
        $service_url = 'http://127.0.0.1:9091/api/get-product-price';
        $token = $this->generate_token();
        $payload = ['id' => (int) $id];
        $client = new \GuzzleHttp\Client();
        $response = $client->post($service_url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($payload),
        ]);
        $data = json_decode($response->getBody(), true);
        return $data;
    }


    public function disable_sell($id)
    {
        $service_url = 'http://127.0.0.1:9091/api/disable-sell';
        $token = $this->generate_token();
        $payload = ['id' => (int) $id];
        $client = new \GuzzleHttp\Client();
        $response = $client->post($service_url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($payload),
        ]);
        $data = json_decode($response->getBody(), true);
        return $data;
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
