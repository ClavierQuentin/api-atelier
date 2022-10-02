<?php

namespace App\Http\Controllers;

use App\Models\DeuxiemeBanniere;
use App\Http\Requests\StoreDeuxiemeBanniereRequest;
use App\Http\Requests\UpdateDeuxiemeBanniereRequest;
use Illuminate\Support\Facades\Auth;

class DeuxiemeBanniereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DeuxiemeBanniere::all();
        if(sizeof($data) > 0){
            return response()->json($data, 200);
        }
        return response()->json(['status'=> false], 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeuxiemeBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeuxiemeBanniereRequest $request)
    {
        $texte = Auth::user()->deuxiemeBannieres()->create($request->validated());
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
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function show(DeuxiemeBanniere $deuxiemeBanniere)
    {
        return response()->json($deuxiemeBanniere, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(DeuxiemeBanniere $deuxiemeBanniere)
    {
        return response()->json($deuxiemeBanniere, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeuxiemeBanniereRequest  $request
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeuxiemeBanniereRequest $request, DeuxiemeBanniere $deuxiemeBanniere)
    {
        $update = $deuxiemeBanniere->update($request->validated());
        if(!$update){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeuxiemeBanniere $deuxiemeBanniere)
    {
        $delete = $deuxiemeBanniere->delete();
        if(!$delete){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),200);
    }
}
