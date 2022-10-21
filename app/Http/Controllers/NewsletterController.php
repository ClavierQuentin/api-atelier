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

        //On ne récupère que les adresses email des inscrits en les enregistrant dans le tableau
        foreach($users as $user){
            $mails_adress[] = $user->email;
        }

        //Envoie du mail avec le tableau de destinataires et l'objet newsletter créé
        Mail::to($mails_adress)
        ->send(new \App\Mail\Newsletter($newsletter));

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
