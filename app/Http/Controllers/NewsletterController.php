<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterRequest;
use App\Models\ListEmail;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{

    //Sauvegarde et envoie de la newsletter
    public function sendEmails(StoreNewsletterRequest $request)
    {

        //Création de l'objet
        $newsletter = new Newsletter($request->validated());

        //On récupère tous les inscrits à la newsletter
        $users = ListEmail::all();

        //On déclare un tableau
        $mails_adress = array();
        $ids = array();

        /**On parcours tous les utilisateurs inscrits pour la newsletter
         * On envoie un mail à chacun, avec l'identifiant unique affilié à l'adresse mail
         * On controle ainsi un minimum car l'url est publique
         */
        foreach($users as $user){
            Mail::to($user->email)->send(new \App\Mail\Newsletter([$newsletter, $user->identifiant]));
        }

        //On sauvegarde l'objet en BDD
        $response = Auth::user()->newsletter()->save($newsletter);

        if($response){
            return redirect('newsletter');
        }
        return redirect('newsletter')->with('error', 'Une erreur est survenue pendant l\'enregistrement');

    }

    //Affichage du formulaire de création
    public function create()
    {
        return view('newsletter.create');
    }

    //Affichage du listing de toutes les newsletters
    public function index()
    {
        //Récupération des toutes les newsletters, classées par date de création décroissante, par 10
        $newsletters = DB::table('newsletters')
                        ->orderByDesc('created_at')
                        ->paginate(10);

        return view('newsletter.index', compact('newsletters'));
    }


    //Affichage des détails d'une newsletter
    public function show(Newsletter $newsletter)
    {
        if(isset($newsletter)){
            return view('newsletter.show', compact('newsletter'));
        }
    }

    //fonction de suppression de l'entrée
    public function destroy(Newsletter $newsletter)
    {
        $delete = $newsletter->delete();

        if($delete){
            return redirect('newsletter');
        }
        abort(500);
    }
}
