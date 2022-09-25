<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //Validation de la requête
        $validate = Validator::make($request->all(),
        [
            'name' =>'required|string|max:250',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Une erreur est survenue',
                'errors'=>$validate->errors()
            ],401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=>Hash::make($request->password)
        ]);
        return response()->json([
            'status'=>true,
            'message'=>'Utilisateur créé avec succès',
            'access_token'=>$user->createToken('access_token')->plainTextToken,
            'token_type'=>'Bearer'
        ],200);
    }

    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(),
        [
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Une erreur est survenue',
                'errors'=>$validateUser->errors()
            ], 401);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'status'=>false,
                'message'=>'L\'email ou/et le mot de passe ne sont pas reconnus'
            ],401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'status'=>true,
            'message'=>'Vous êtes bien connecté',
            'access_token'=>$user->createToken('access_token')->plainTextToken,
            'token_type'=>'Bearer'
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json('Vous êtes déconnecté');
    }
}
