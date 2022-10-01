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
        $data = TexteAccueil::all();
        if(sizeof($data) > 0){
            return response()->json($data, 200);
        }
        return response()->json(['status'=> false], 204);
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
        $texte = Auth::user()->texteAccueils()->create($request->all());
        return response()->json([
            'status'=>'success',
            'message'=>'New entry added successfully.'
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
        return response()->json($texteAccueil, 200);
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
        $texteAccueil->update($request->only('titre_accueil','texte_accueil','titre_categories'));
        return response()->json(array('success' => true),200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TexteAccueil  $texteAccueil
     * @return \Illuminate\Http\Response
     */
    public function destroy(TexteAccueil $texteAccueil)
    {
        $texteAccueil->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data deleted successfully.',
        ],200);
    }
}
