<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class RecaptchaController extends Controller
{
    public function googleResponse($token)
    {
        $recaptchaToken = $token;
        $secretKey = env('SECRET_KEY');

        $response = Http::post("https://www.google.com/recaptcha/api/siteverify?secret='$secretKey'&response='$recaptchaToken");

        return response()->json($response,200);
        if($response->success){
            return response()->json(['status' => 'success'], 200);
        }
    }
}
