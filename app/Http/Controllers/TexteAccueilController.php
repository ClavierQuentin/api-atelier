<?php

namespace App\Http\Controllers;

use App\Models\TexteAccueil;
use App\Http\Requests\StoreTexteAccueilRequest;
use App\Http\Requests\UpdateTexteAccueilRequest;
use App\Models\Carrousel;
use App\Models\Produit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TexteAccueilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TexteAccueil::paginate(10);

        return view('texteAccueil.index',['data'=>$data]);
    }

    //Fonction pour l'accès via API
    public function indexFront()
    {
        $texteAccueil = DB::table('texte_accueils')
                        ->where('online', '=', 1)
                        ->first();

        $categories = DB::table('categories')
        ->where('isAccueil','=', 1)
        ->orderByDesc('updated_at')
        ->limit("4")
        ->get();

        $produits = DB::select('select * from produits where isAccueil = ?', [1]);

        $url = [];
        foreach($produits as $produit){
            $produit = Produit::find($produit->id);
            $url[] = $produit->images->first()->url;
        }

        $carrousels = Carrousel::all();

        //On contrôle la présence des données
        if(isset($texteAccueil) && isset($categories)){
            return view('front.home', compact('texteAccueil', 'categories', 'carrousels'));
        }
        return response()->json(['status' => false], 404);
    }

    //Affichage du formulaire de création
    public function create()
    {
        return view('texteAccueil.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTexteAccueilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTexteAccueilRequest $request)
    {
        $texte = new TexteAccueil($request->validated());

        $texte = Auth::user()->texteAccueils()->save($texte);

        if($texte){
            return redirect('texte-accueil');
        }
        abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TexteAccueil  $texteAccueil
     * @return \Illuminate\Http\Response
     */
    public function edit(TexteAccueil $texteAccueil)
    {
        return view('texteAccueil.edit',['texteAccueil' => $texteAccueil]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTexteAccueilRequest  $request
     * @param  \App\Models\TexteAccueil  $texteAccueil
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTexteAccueilRequest $request, TexteAccueil $texteAccueil)
    {
        $update = $texteAccueil->update($request->validated());

        if($update){
            return redirect('texte-accueil');
        }
        abort(404);
    }

    //Fonction pour mettre a jour le booleen en DB pour mettre en avant une data
    public function updateOnline(UpdateTexteAccueilRequest $request, TexteAccueil $texteAccueil)
    {
        //On récupère toutes les données pour changer la valeur de Online à 0
        $all = TexteAccueil::all();

        if(isset($all) && sizeof($all) > 0){
            foreach ($all as $item){
                $item->online = "0";
                $item->save();
            }//foreach
        }//if

        //On change la valeur du modèle en cours de sélection
        $texteAccueil->online = 1;
        $response = $texteAccueil->save();

        if($response){
            return redirect('texte-accueil');
        }
        abort(404);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TexteAccueil  $texteAccueil
     * @return \Illuminate\Http\Response
     */
    public function destroy(TexteAccueil $texteAccueil)
    {
        $delete = $texteAccueil->delete();
        if($delete){
            return redirect('texte-accueil');
        }
        abort(404);
    }
}
