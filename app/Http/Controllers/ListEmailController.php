<?php

namespace App\Http\Controllers;

use App\Models\ListEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ListEmailController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreListEmailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Récupération du Token google côté client pour le faire vérifier
        $recaptchaToken = $request['token'];
        $secretKey = env('SECRET_KEY');

        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$recaptchaToken);

        //Si échec on interrompe
        if($response->failed()){
            return redirect('accueil')->with('message', $response);
        }

        //Si captcha OK et honeypot vide, on procède à la suite
        if($response->ok() && $request['pot'] == NULL){

            //Regles de validation
            $validator = Validator::make($request->all(),[
                'email' => 'required|email:rfc,dns|unique:list_emails|max:255',
            ]);

            //Si validation échoue, on interrompe
            if($validator->fails()){
                $errors = $validator->errors();

                if($errors->first() == "The email has already been taken."){
                    return redirect('accueil')->with('message', 'Adresse déjà inscrite');
                }
                return redirect('accueil')->with('message', $errors->first());
            }
            //sinon on récupère les données validées
            $validated = $validator->validated();

            $item = new ListEmail($validated);

            //Génération d'un id unique par email
            $item->identifiant = uniqid();

            $saved = $item->save();

            //Si la sauvegarde est faite, on retourne un message de succès
            if($saved){
                return redirect('accueil')->with('message', 'Inscription réalisée');
            }
            //Si sauvegarde échouée, message d'erreur
            return redirect('accueil')->with('message', 'Une erreur est survenue');

        }

        //Si une erreur survient au captcha ou que le honeypot est utilisée, un indique un message d'erreur
        return redirect('accueil')->with('message', 'Une erreur est survenue');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
        {

        if(!isset($request['identifiant'])){
            abort(403);
        }

        //Regle de validation
        $validator = Validator::make($request->all(),[
            'email' => 'email',
            'identifiant' => 'string'
        ]);
        if($validator->fails()){
            abort(403);
        }

        //si les données sont validées, on les récupère
        $validated = $validator->validated();

        //On retrouve la donnée en BDD grace au mail donné
        $listEmail = DB::table('list_emails')
                    ->where('email', '=', $validated['email'])
                    ->where('identifiant', '=', $validated['identifiant'])
                    ->first();
        if(isset($listEmail)){
            $listEmail = ListEmail::find($listEmail->id);

            //On supprime l'entrée
           $delete =  $listEmail->delete();

           if($delete){
            return view('newsletter.delete');
           }
           abort(500);

        }
        abort(404);
    }

    public function edit()
    {
        //On récupère l'identifiant unique de la personne passé en paramètre de l'url
        $token = $_GET['id'];
        return view('newsletter.edit_email', compact('token'));
    }
}
