<?php

namespace App\Http\Controllers;

use App\Models\ListEmail;
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
                'prenom' => 'required|string|max:200',
                'nom' => 'required|string|max:200',
                'sujet' => 'required|string|max:250',
                'email' => 'required|email:rfc,dns|max:250',
                'message' => 'required|string',
                'newsletter' => 'boolean'
            ]);

            //si vérification échoue, on retourne le message d'erreur
            if($validator->fails()){
                return response()->json(['status' => false, 'errors'=> $validator->errors()->first()], 404);
            }

            //Si validation passe, on récupère les données validées
            $validated = $validator->validated();

            //Si checkbox newsletter true pour inscription
            if($validated['newsletter']){

                //On contrôle si la donnée entrante est déjà existante en BDD
                $alreadyIn = ListEmail::where('email','=', $validated['email'])->first();

                if($alreadyIn == NULL){
                    $item = new ListEmail($validated);

                    //Génération d'un id unique par email
                    $item->identifiant = uniqid();

                    $savedEmail = $item->save();
                    //En cas d'erreur
                    if(!$savedEmail){
                        return response()->json(['status' => false, 'message' => 'Une erreur est survenue'], 404);
                    }
                }
                return response()->json(['status' => false, 'message' => 'Vous êtes déjà inscrit à la newsletter'], 404);
            }


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
