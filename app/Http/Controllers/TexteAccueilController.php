<?php

namespace App\Http\Controllers;

use App\Models\TexteAccueil;
use App\Http\Requests\StoreTexteAccueilRequest;
use App\Http\Requests\UpdateTexteAccueilRequest;
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

    //Fonction pour l'acc�s via API
    public function indexApi()
    {
        $texteAccueil = DB::table('texte_accueils')
                        ->where('online', '=', 1)
                        ->first();
        if(isset($texteAccueil)){
            return response()->json($texteAccueil, 200);
        }
        return response()->json(['status' => false], 404);
    }

    //Affichage du formulaire de cr�ation
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
        // $texte->online = 0;
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
        //On r�cup�re toutes les donn�es pour changer la valeur de Online � 0
        $all = TexteAccueil::all();
        if(isset($all) && sizeof($all) > 0){
            foreach ($all as $item){
                $item->online = "0";
                $item->save();
            }//foreach
        }//if

        //On change la valeur du mod�le en cours de s�lection
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
