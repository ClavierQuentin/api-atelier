<?php

namespace App\Http\Controllers;

use App\Models\TexteAccueil;
use App\Http\Requests\StoreTexteAccueilRequest;
use App\Http\Requests\UpdateTexteAccueilRequest;
use Illuminate\Support\Facades\Auth;

class TexteAccueilController extends Controller
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
     * @param  \App\Http\Requests\StoreTexteAccueilRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTexteAccueilRequest $request)
    {
        $texte = Auth::user()->texteAccueils()->create([
            'titre_accueil'=>$request->titre_accueil,
            'texte_accueil'=>$request->texte_accueil,
            'titre_categories'=>$request->titre_categories
            ]);
        return response()->json([
            'status'=>true,
            'message'=>'Enregistrement réussi'
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TexteAccueil  $texteAccueil
     * @return \Illuminate\Http\Response
     */
    public function show(TexteAccueil $texteAccueil)
    {
        $texte = TexteAccueil::find($texteAccueil);
        return response()->json($texte, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TexteAccueil  $texteAccueil
     * @return \Illuminate\Http\Response
     */
    public function edit(TexteAccueil $texteAccueil)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TexteAccueil  $texteAccueil
     * @return \Illuminate\Http\Response
     */
    public function destroy(TexteAccueil $texteAccueil)
    {
        //
    }
}
