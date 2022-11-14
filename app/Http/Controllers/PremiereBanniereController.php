<?php

namespace App\Http\Controllers;

use App\Models\PremiereBanniere;
use App\Http\Requests\StorePremiereBanniereRequest;
use App\Http\Requests\UpdatePremiereBanniereRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class PremiereBanniereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $premiereBannieres = PremiereBanniere::paginate(10);

        return view('premiereBannieres.index',['premiereBannieres' => $premiereBannieres]);

    }

    //Controller pour l'API coté Front
    public function indexApi()
    {
        $premiereBanniere = DB::table('premiere_bannieres')
                        ->where('online', '=', '1')
                        ->first();

        //On contrôle la présence des données
        if(isset($premiereBanniere)){
            return response()->json($premiereBanniere, 200);
        }
        return response()->json(['status'=> false], 404);
    }

    //affichage du formulaire
    public function create()
    {
        $images = Image::all();
        return view('premiereBannieres.create', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePremiereBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePremiereBanniereRequest $request)
    {

        //CRéation d'un nouvel objet
        $premiereBanniere = new PremiereBanniere($request->validated());

        if($request['image']){
            $image = Image::find($request['image']);
            $premiereBanniere->image()->associate($image);
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
                return redirect('premiere-banniere/create')
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            $path = $validatedData['imageDL']->storeAs('images', $validatedData['imageDL']->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);

            $premiereBanniere->image()->associate($image);
        }
        $all = PremiereBanniere::all();

        //On passe toutes les entrées à 0
        if(isset($all)){
            foreach ($all as $item){
                $item->online = "0";
                $item->save();
            }
        }
        //ON passe la nouvelle entrée en ligne
        $premiereBanniere->online = '1';

        //Enregistrement en DB
        $response = Auth::user()->premiereBannieres()->save($premiereBanniere);

        if($response){
            return redirect('premiere-banniere');
        }
        return redirect('premiere-banniere')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PremiereBanniere  $premiereBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(PremiereBanniere $premiereBanniere)
    {
        $images = Image::all();
        return view('premiereBannieres.edit',compact('premiereBanniere', 'images'));
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
        if($request['image'] != NULL){
            //On supprime le lien existant en premier
            $premiereBanniere->image()->dissociate();

            $image = Image::find($request['image']);
            $premiereBanniere->image()->associate($image);
        }

        //Si une image est fournie via le formulaire
        if($request['imageDL'] != NULL){
            //Règles de validation
            $validator = Validator::make($request->all(), [
                'imageDL' => 'image',
            ],[
                'image' =>'Le fichier doit être une image'
            ]);

            if($validator->fails()){
                return redirect('premiere-banniere/edit/'.$premiereBanniere->id)
                ->withErrors($validator)
                ->withInput();
            }

            //On recupère les données validées
            $validatedData = $validator->validated();

            $path = $validatedData['imageDL']->storeAs('images', $validatedData['imageDL']->getClientOriginalName(), ['disk'=>'public']);
            $image = new Image();
            $image->url = $path;

            Auth::user()->image()->save($image);

            //On supprime le lien existant en premier
            $premiereBanniere->image()->dissociate();

            $premiereBanniere->image()->associate($image);
        }

        //Enregistrement en base
        $update = $premiereBanniere->update($request->validated());

        //On controle la sortie, si l'update a bien �t� faite.
        if($update){
            return redirect('premiere-banniere');
        }
        return redirect('premiere-banniere')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
    }


    //Fonction pour mettre a jour le booleen en DB pour mettre en avant une data
    public function updateOnline( PremiereBanniere $premiereBanniere)
    {
        $all = PremiereBanniere::all();

        //On passe toutes les entrées à 0
        if(isset($all)){
            foreach ($all as $item){
                $item->online = "0";
                $item->save();
            }
        }

        //On passe l'entrée séléctionnée à 1 et on sauvegarde
        $premiereBanniere->online = 1;
        $response = $premiereBanniere->save();

        if($response){
            return redirect('presentation');
        }
        abort(404);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PremiereBanniere  $premiereBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(PremiereBanniere $premiereBanniere)
    {
        //Suppression en BDD
        $delete = $premiereBanniere->delete();

        if(!$delete){
            abort(500);
        }
        return redirect('premiere-banniere');
    }


}
