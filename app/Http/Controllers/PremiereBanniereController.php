<?php

namespace App\Http\Controllers;

use App\Models\PremiereBanniere;
use App\Http\Requests\StorePremiereBanniereRequest;
use App\Http\Requests\UpdatePremiereBanniereRequest;
use Illuminate\Support\Facades\Auth;

class PremiereBanniereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PremiereBanniere::all();
        if(sizeof($data) > 0){
            return response()->json($data, 200);
        }
        return response()->json(['status'=> false], 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePremiereBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePremiereBanniereRequest $request)
    {
        $texte = Auth::user()->premiereBannieres()->create($request->validated());
        if(!empty($texte)){
            return response()->json([
                'status'=>'success',
                'message'=>'New entry added successfully.'
            ],201);
        }
        return response()->json(array('status'=>false), 500);
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PremiereBanniere  $premiereBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(PremiereBanniere $premiereBanniere)
    {
        return response()->json($premiereBanniere, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePremiereBanniereRequest  $request
     * @param  \App\Models\PremiereBanniere  $premiereBanniere
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePremiereBanniereRequest $request, PremiereBanniere $premiereBanniere)
    {
        $update = $premiereBanniere->update($request->validated());
        if(!$update){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PremiereBanniere  $premiereBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(PremiereBanniere $premiereBanniere)
    {
        $delete = $premiereBanniere->delete();
        if(!$delete){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),200);
    }
}
