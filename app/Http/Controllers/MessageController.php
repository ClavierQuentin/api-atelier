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

        //Si une erreur survient, on interrompe
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
                'email' => 'required|email:rfc,dns',
                'message' => 'required|string'
            ]);

            //si vérification échoue, on retourne le message d'erreur
            if($validator->fails()){
                return response()->json(['status' => false, 'errors'=> $validator->errors()], 404);
            }

            //Si validation passe, on récupère les données validées
            $validated = $validator->validated();

            //Nouvel objet
            $message = new Message($validated);

            //Envoie du mail en utilisant le model mailable MessageMail et les données entrantes
            Mail::to('clavier.quentin@gmail.com')->send(new \App\Mail\MessageMail($message));

            //Sauvegarde en base de données
            $saved = $message->save();

            if($saved){
                return response()->json(['status' => true, 'message' => 'Votre message a bien été envoyé'], 200);
            }
            return response()->json(['status' => false, 'message' => 'Une erreur est survenue'], 404);
        }

        return response()->json(['status' => false, 'message' => 'Une erreur est survenue'], 404);

    }

}
