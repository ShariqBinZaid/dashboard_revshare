<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontController extends Controller
{
    public function home()
    {
        return view('front.home');
    }
    public function about()
    {
        return view('front.about');
    }
    public function custom()
    {
        return view('front.custom');
    }
    public function whatuslife()
    {
        return view('front.whatuslife');
    }
    public function packages()
    {
        $pkgs = Http::accept('application/json')->get(env('API_URL') . 'packages');
        $data['pkgs'] = $pkgs->json();
        return view('front.packages')->with($data);
    }
    public function healthform(Request $req)
    {
        $health = Http::accept('application/json')->post(env('API_URL') . 'health', $req);
        $data = $health->json();
        return response()->json(['success' => true, 'data' => $data, 'msg' => 'Mental Health Registered Successfully']);
    }
    public function registerapi(Request $req)
    {
        $reg = Http::accept('application/json')->post(env('API_URL') . 'register', $req);
        $data = $reg->json();
        return response()->json(['success' => true, 'data' => $data, 'msg' => 'User Registered Successfully']);
    }
    public function loginapi(Request $req)
    {
        $login = Http::accept('application/json')->post(env('API_URL') . 'login', $req);
        $data = $login->json();
        return response()->json(['success' => true, 'data' => $data, 'msg' => 'User Login Successfully']);
    }
    public function userupdate(Request $req)
    {
        $userupdate = Http::accept('application/json')->post(env('API_URL') . 'userupdate', $req);
        $data = $userupdate->json();
        return response()->json(['success' => true, 'data' => $data, 'msg' => 'User Update Successfully']);
    }
    public function phoneotp(Request $req)
    {
        $phoneotp = Http::accept('application/json')->post(env('API_URL') . 'phoneotp', $req);
        $data = $phoneotp->json();
        return response()->json(['success' => true, 'data' => $data, 'msg' => 'OTP Send Successfully']);
    }
}
