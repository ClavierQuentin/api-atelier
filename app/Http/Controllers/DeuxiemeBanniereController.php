<?php

namespace App\Http\Controllers;

use App\Models\DeuxiemeBanniere;
use App\Http\Requests\StoreDeuxiemeBanniereRequest;
use App\Http\Requests\UpdateDeuxiemeBanniereRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Requests\Request;
use App\Models\Image;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;

class DeuxiemeBanniereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deuxiemeBannieres = DeuxiemeBanniere::paginate(10);

        return view('deuxiemeBannieres.index',['deuxiemeBannieres' => $deuxiemeBannieres]);

    }


    //Affichage du formulaire de création
    public function create()
    {
        $images = Image::all();
        return view('deuxiemeBannieres.create', compact('images'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeuxiemeBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeuxiemeBanniereRequest $request)
    {

        //Création du nouvel objet
        $deuxiemeBanniere = new DeuxiemeBanniere($request->validated());
        
        $all = DeuxiemeBanniere::all();

        //On passe toutes les entrées à 0
        if(isset($all)){
            foreach ($all as $item){
                $item->online = "0";
                $item->save();
            }
        }
        //ON passe la nouvelle entrée en ligne
        $deuxiemeBanniere->online = '1';

        //Enregistrement en DB
        $response = Auth::user()->deuxiemeBannieres()->save($deuxiemeBanniere);

        if($request['image']){
            foreach($request['image'] as $file){
                $image = Image::find($file);
                $deuxiemeBanniere->images()->attach($image);
            }
        }

        if($request['imageDL']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL.*' => 'image',
                'imageDL'=>'required'
            ],[
                'imageDL.required' => 'Une image est requise',
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('deuxieme-banniere/create')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            foreach($validatedData['imageDL'] as $file){
                $path = $file->storeAs('images', $file->getClientOriginalName(), ['disk'=>'public']);
                $image = new Image();
                $image->url = $path;

                Auth::user()->image()->save($image);

                $deuxiemeBanniere->images()->attach($image);
            }

        }

        if($response){
            return redirect('deuxieme-banniere');
        }
        return redirect('deuxieme-banniere')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(DeuxiemeBanniere $deuxiemeBanniere)
    {
        $images = Image::all();
        return view('deuxiemeBannieres.edit',compact('deuxiemeBanniere', 'images'));
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

        //Si checkbox deleteImage = true, on supprime les images existantes
        if(isset($request['deleteAllImages']) && $request['deleteAllImages'] == true) {
            foreach($deuxiemeBanniere->images as $image){
                $deuxiemeBanniere->images()->detach($image);
            }
        }

        //Si choix d'images déjà existantes
        if($request['image']){
            foreach($request['image'] as $file){
                $image = Image::find($file);
                $deuxiemeBanniere->images()->attach($image);
            }
        }

        if($request['imageDL']){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL.*' => 'image',
            ],[
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('deuxieme-banniere/edit/'.$deuxiemeBanniere->id)
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            foreach($validatedData['imageDL'] as $file){
                $path = $file->storeAs('images', $file->getClientOriginalName(), ['disk'=>'public']);
                $image = new Image();
                $image->url = $path;

                Auth::user()->image()->save($image);

                $deuxiemeBanniere->images()->attach($image);
            }

        }


        //Update
        $update = $deuxiemeBanniere->update($request->validated());

        //On controle la sortie, si l'update a bien été faite.
        if($update){
            return redirect('deuxieme-banniere');
        }
        return redirect('deuxieme-banniere')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeuxiemeBanniere $deuxiemeBanniere)
    {
        //On supprime l'objet selectionné
        $delete = $deuxiemeBanniere->delete();
        if(!$delete){
            abort(404);
        }
        return redirect('deuxieme-banniere');
    }

    //Fonction pour supprimer 1 image précise
    /**
     * Fonction pour supprimer 1 image précise
     * @param Model DeuxiemeBanniere $deuxiemeBanniere
     * @param Url Image $image
     */
    public function deleteImage(DeuxiemeBanniere $deuxiemeBanniere, $image)
    {
        $image = Image::find($image);

        $deuxiemeBanniere->images()->detach($image);

        $images = Image::all();

        return view('deuxiemeBannieres.edit', compact('deuxiemeBanniere', 'images'));
    }

    //Fonction pour mettre a jour le booleen en DB pour mettre en avant sur le front une donnée
    public function updateOnline(DeuxiemeBanniere $deuxiemeBanniere)
    {
        //On met tous les modèles à 0
        $all = DeuxiemeBanniere::all();

        if(isset($all)){
            foreach ($all as $item){
                $item->online = "0";
                $item->save();
            }
        }

        //On passe le modèle en cours à 1
        $deuxiemeBanniere->online = 1;
        //On enregistre le changement
        $response = $deuxiemeBanniere->save();

        if($response){
            return redirect('presentation');
        }
        abort(404);
    }
}
