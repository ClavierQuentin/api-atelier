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

    //Controller pour l'API coté Front
    public function indexApi()
    {
        //On récupère les données dont Online est à 1
        $deuxiemeBanniere = DB::table('deuxieme_bannieres')
                        ->where('online', '=', '1')
                        ->first();

        //On contrôle que la donnée est existante
        if(isset($deuxiemeBanniere)){
            //on retourne le tableau d'urls d'image décodé pour la lecture au front
            return response()->json(['data'=>$deuxiemeBanniere,'urls'=>json_decode($deuxiemeBanniere->url_image)], 200);
        }

        return response()->json(['status'=>false], 404);
    }

    //Affichage du formulaire de création
    public function create()
    {
        return view('deuxiemeBannieres.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeuxiemeBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeuxiemeBanniereRequest $request)
    {
        //Déclaration d'un tableau vide
        $data = array();

        //Règles de validation du fichier
        $this->validate($request ,[
            'image'=>'required',
            'image.*'=>'mimes:jpg,jepg,png,JPG,JPEG'
        ]);

        //On upload chaque image et on stocke l'url d'accès
        foreach($request->file('image') as $file){
            $path = cloudinary()->upload($file->getRealPath())->getSecurePath();
            $data[] = $path;
        }

        //Création du nouvel objet
        $deuxiemeBanniere = new DeuxiemeBanniere($request->validated());

        //On enregistre le tableau d'url encodé en JSON
        $deuxiemeBanniere->url_image = json_encode($data);

        //Enregistrement en DB
        $response = Auth::user()->deuxiemeBannieres()->save($deuxiemeBanniere);

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
        return view('deuxiemeBannieres.edit',['deuxiemeBanniere'=>$deuxiemeBanniere]);
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
        //On récupère les urls existantes en base
        $data = $deuxiemeBanniere->getArrayFromUrlsImages();

        //Si checkbox deleteImage = true, on supprime les images existantes
        if(isset($request['deleteAllImages']) && $request['deleteAllImages'] == true) {

            //Suppression en ligne
            $deuxiemeBanniere->deleteImages(); //Voir model

            //On vide le tableau d'urls
            $data= [];
        }


        //Si une image a été envoyée au formulaire
        if($request->file('image') != null){
            //Regle de validation du fichier image
            $this->validate($request ,[
                'image'=>'required',
                'image.*'=>'mimes:jpg,jepg,png,JPG,JPEG'
            ]);
            //Upload des nouvelles images et enregistrement de l'url d'accès
            foreach($request->file('image') as $file){
                $path = cloudinary()->upload($file->getRealPath())->getSecurePath();
                $data[] = $path;
            }
        }

        //On enregistre les nouvelles urls si présentent, sinon le tableau vide
        $deuxiemeBanniere->url_image = json_encode($data);

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
        //Suppression des images stockées au cloud
        if($deuxiemeBanniere->url_image != NULL){
            $deuxiemeBanniere->deleteImages(); //Voir model
        }


        //On supprime l'objet selectionné
        $delete = $deuxiemeBanniere->delete();
        if(!$delete){
            abort(404);
        }
        return view('deuxiemeBannieres.index');
    }

    //Fonction pour supprimer 1 image précise
    /**
     * Fonction pour supprimer 1 image précise
     * @param Model DeuxiemeBanniere $deuxiemeBanniere
     * @param Url Image $image
     */
    public function deleteImage(DeuxiemeBanniere $deuxiemeBanniere, $image)
    {

        //On récupère toutes les urls, on les stock et on les parcours
        $array = $deuxiemeBanniere->getArrayFromUrlsImages();

        for($i = 0; $i < sizeof($array); $i++){

            //Déclaration des variables
            $publicId = "";
            $fileName = "";

            //On décompose l'url stockée en DB
            $fileName = explode("/", $array[$i]);

            //On récupère  le nom de l'image dans l'url
            $publicId = $fileName[count($fileName)-1];

            //On récupère le nom sans l'extension
            $publicName = explode(".", $publicId)[0];

            //Comparaison avec les valeurs en DB
            if($publicId == $image){

                //ON efface dans le tableau
                array_splice($array, $i, 1);

                //On efface sur cloudinary
                $result = Cloudinary::destroy($publicName);

            }//if

        }//For

        //On enregistre le nouveau tableau d'url
        $deuxiemeBanniere->url_image = json_encode($array);

        $delete = $deuxiemeBanniere->save();

        if($delete){
            return view('deuxiemeBannieres.edit', compact('deuxiemeBanniere'));
        }
        abort(404);
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
