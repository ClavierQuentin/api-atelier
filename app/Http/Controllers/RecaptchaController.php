<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class RecaptchaController extends Controller
{
    public function googleResponse($token)
    {
            $recaptchaToken = $token;
            $secretKey = env('SECRET_KEY');

            $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$recaptchaToken);

            if($response->ok()){
                return response($response->body(),200);
            }
            if($response->failed()){
                return response()->json(['status' => 'false'], 500);
            }
    }
}
