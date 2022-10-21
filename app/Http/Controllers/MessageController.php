<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Récupération du Token google côté client pour le faire vérifier
        $recaptchaToken = $request['token'];
        $secretKey = env('SECRET_KEY');

        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$recaptchaToken);

        if($response->failed()){
            return response()->json(['status' => 'false'], 500);
        }

        //Si captcha OK et honeypot vide, on procèe à la suite
        if($response->ok() && $request['pot'] == NULL){

            //Regles de validation
            $validator = Validator::make($request->all(),[
                'prenom' => 'required|string',
                'nom' => 'required|string',
                'sujet' => 'required|string',
                'email' => 'required|string',
                'message' => 'required|string'
            ]);

            if($validator->fails()){
                return response()->json(['status' => false, 'errors'=> $validator->errors()], 404);
            }
            $validated = $validator->validated();

            //Nouvelobjet
            $message = new Message($validated);

            //Envoir du mail
            Mail::to('clavier.quentin@gmail.com')->send(new \App\Mail\MessageMail($message));

            //Sauvegarde en base de données
            $saved = $message->save();

            if($saved){
                return response()->json(['status' => true], 200);
            }
            return response()->json(['status' => false], 404);
        }

        return response()->json(['status' => false], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
