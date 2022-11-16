<?php

namespace App\Http\Controllers;

use App\Models\TroisiemeBanniere;
use App\Http\Requests\StoreTroisiemeBanniereRequest;
use App\Http\Requests\UpdateTroisiemeBanniereRequest;
use App\Models\Image;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class TroisiemeBanniereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $troisiemeBannieres = TroisiemeBanniere::paginate(10);

        return view('troisiemeBannieres.index',['troisiemeBannieres' => $troisiemeBannieres]);
    }


    //Direction pour le formulaire de création
    public function create()
    {
        $images = Image::all();
        return view('troisiemeBannieres.create', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTroisiemeBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTroisiemeBanniereRequest $request)
    {
        //Création du nouvel objet
        $troisiemeBanniere = new TroisiemeBanniere($request->validated());

        if($request['image']){
            $image = Image::find($request['image']);
            $troisiemeBanniere->image()->associate($image);
        }
        if($request['image2']){
            $image = Image::find($request['image2']);
            $troisiemeBanniere->image2()->associate($image);
        }

        //Si une image est fournie via le formulaire
        if($request['imageDL']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL' => 'image|required',
            ],[
                'required' => 'Une image est requise',
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('troisieme-banniere/create')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            $path = $validatedData['imageDL']->storeAs('images', $validatedData['imageDL']->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);

            $troisiemeBanniere->image()->associate($image);
        }

        if($request['imageDL2']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL2' => 'image|required',
            ],[
                'required' => 'Une image est requise',
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('troisieme-banniere/create')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            $path = $validatedData['imageDL2']->storeAs('images', $validatedData['imageDL2']->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);

            $troisiemeBanniere->image2()->associate($image);
        }

        $all = TroisiemeBanniere::all();

        //On passe toutes les entrées à 0
        if(isset($all)){
            foreach ($all as $item){
                $item->online = "0";
                $item->save();
            }
        }
        //ON passe la nouvelle entrée en ligne
        $troisiemeBanniere->online = '1';


        //Enregistrement en DB
        $response = Auth::user()->troisiemeBannieres()->save($troisiemeBanniere);

        if($response){
            return redirect('troisieme-banniere');
        }
        return redirect('troisieme-banniere')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(TroisiemeBanniere $troisiemeBanniere)
    {
        $images = Image::all();
        return view('troisiemeBannieres.edit', compact('troisiemeBanniere', 'images'));
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
        if($request['image']){
            $troisiemeBanniere->image()->dissociate();

            $image = Image::find($request['image']);
            $troisiemeBanniere->image()->associate($image);
        }
        if($request['image2']){
            $troisiemeBanniere->image2()->dissociate();

            $image = Image::find($request['image2']);
            $troisiemeBanniere->image2()->associate($image);
        }

        //Si une image est fournie via le formulaire
        if($request['imageDL']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL' => 'image',
            ],[
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('troisieme-banniere/create')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            $path = $validatedData['imageDL']->storeAs('images', $validatedData['imageDL']->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);

            $troisiemeBanniere->image()->dissociate();

            $troisiemeBanniere->image()->associate($image);
        }

        if($request['imageDL2']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL2' => 'image|required',
            ],[
                'required' => 'Une image est requise',
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('troisieme-banniere/create')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            $path = $validatedData['imageDL2']->storeAs('images', $validatedData['imageDL2']->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);

            $troisiemeBanniere->image2()->dissociate();

            $troisiemeBanniere->image2()->associate($image);
        }

        //On enregistre en base
        $update = $troisiemeBanniere->update($request->validated());

        if($update){
            return redirect('troisieme-banniere');
        }
        return redirect('troisieme-banniere')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
}


    //Fonction pour mettre a jour le booleen en DB pour mettre en avant une data
    public function updateOnline( TroisiemeBanniere $troisiemeBanniere)
    {
        $all = TroisiemeBanniere::all();

        //On passe toutes les entrées à 0
        if(isset($all) && sizeof($all) > 0)
        foreach ($all as $item){
            $item->online = "0";
            $item->save();
        }

        //On passe l'entrée en cours à 1
        $troisiemeBanniere->online = 1;
        $troisiemeBanniere->save();

        return redirect('presentation');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(TroisiemeBanniere $troisiemeBanniere)
    {
        //Suppression en base
        $delete = $troisiemeBanniere->delete();
        if(!$delete){
            abort(404);
        }
        return view('troisiemeBannieres.index');

    }
}
