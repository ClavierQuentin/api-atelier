<?php

namespace App\Http\Controllers;

use App\Models\TroisiemeBanniere;
use App\Http\Requests\StoreTroisiemeBanniereRequest;
use App\Http\Requests\UpdateTroisiemeBanniereRequest;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class TroisiemeBanniereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TroisiemeBanniere::all();
        if(sizeof($data) > 0){
            return response()->json($data, 200);
        }
        return response()->json(['status'=> false], 204);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTroisiemeBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTroisiemeBanniereRequest $request)
    {
        $texte = Auth::user()->troisiemeBannieres()->create($request->all());
        if(!empty($texte)){
            return response()->json([
                'status'=>'success',
                'message'=>'New entry added successfully.'
            ],201);
        }
        return response()->json(array('status'=>false), 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function show(TroisiemeBanniere $troisiemeBanniere)
    {
        return response()->json($troisiemeBanniere, 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(TroisiemeBanniere $troisiemeBanniere)
    {
        return response()->json($troisiemeBanniere, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTroisiemeBanniereRequest  $request
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTroisiemeBanniereRequest $request, TroisiemeBanniere $troisiemeBanniere)
    {
        $update = $troisiemeBanniere->update($request->validated());
        if(!$update){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(TroisiemeBanniere $troisiemeBanniere)
    {
        $delete = $troisiemeBanniere->delete();
        if(!$delete){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),200);

    }
}
