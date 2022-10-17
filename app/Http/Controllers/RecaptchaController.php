<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecaptchaController extends Controller
{
    public function googleResponse(Request $request)
    {
        $recaptchaToken = $request->data["recaptcha"];
        $secretKey = env('SECRET_KEY');

        $response = Http::post("https://www.google.com/recaptcha/api/siteverify?secret='$secretKey'&response='$recaptchaToken");

        if($response->success){
            return response()->json(['status' => 'success'], 200);
        }
    }
}
