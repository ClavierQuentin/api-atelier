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
        $deuxiemeBannieres = DeuxiemeBanniere::all();

        if(isset($deuxiemeBannieres)){
            return view('deuxiemeBannieres.index',['deuxiemeBannieres' => $deuxiemeBannieres]);
        }
        abort(500);

    }

    //Controller pour l'API cot� Front
    public function indexApi()
    {
        $data = DeuxiemeBanniere::all();
        if(isset($data)){
            return response()->json($data, 200);
        }
        return response()->json(['status'=> false], 204);
    }

    //Affichage du formulaire de cr�ation
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
        $data = array();

        //R�gles de validation du fichier
        $this->validate($request ,[
            'image'=>'required',
            'image.*'=>'mimes:jpg,jepg,png,JPG,JPEG'
        ]);

        //On upload chaque image
        foreach($request->file('image') as $file){
            $path = cloudinary()->upload($file->getRealPath())->getSecurePath();
            $data[] = $path;
        }

        //Cr�ation du nouvel objet
        $deuxiemeBanniere = new DeuxiemeBanniere($request->validated());

        //On enregistre certain param�tres
        $deuxiemeBanniere->url_image = json_encode($data);
        $deuxiemeBanniere->online = 0;

        //Enregistrement en DB
        $response = Auth::user()->deuxiemeBannieres()->save($deuxiemeBanniere);

        if($response){
            return redirect('deuxieme-banniere');
        }
        return redirect('deuxieme-banniere')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function show(DeuxiemeBanniere $deuxiemeBanniere)
    {
        $deuxiemeBanniere = DB::table('deuxieme_bannieres')
                        ->where('online', '=', '1')
                        ->first();

        if(isset($deuxiemeBanniere)){
            return response()->json($deuxiemeBanniere, 200);
        }

        return response()->json(['message'=>'Une erreur est survenue'], 204);
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
        $data = array();

        //Si une image a �t� envoy� au formulaire
        if($request->file('image') != null){
            //Regle de validation du fichier image
            $this->validate($request ,[
                'image'=>'required',
                'image.*'=>'mimes:jpg,jepg,png,JPG,JPEG'
            ]);
            //Upload des nouvelles images
            foreach($request->file('image') as $file){
                $path = cloudinary()->upload($file->getRealPath())->getSecurePath();
                $data[] = $path;
            }
        }

        //Si checkbox deleteImage = true, on supprime les images existantes
        if(isset($request['deleteAllImages']) && $request['deleteAllImages'] == true) {

            $deuxiemeBanniere->deleteImages(); //Voir model

            $deuxiemeBanniere->url_image = json_encode($data); //On enregistre les nouvelles urls si pr�sentent, sinon un tableau vide
        }


        //Update
        $update = $deuxiemeBanniere->update($request->validated());

        //On contr�le la sortie, si l'update a bien �t� faite.
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
        //Suppression des images stock�es au cloud
        $deuxiemeBanniere->deleteImages(); //Voir model


        //On supprime l'objet selectionn�
        $delete = $deuxiemeBanniere->delete();
        if(!$delete){
            abort(500);
        }
        return view('deuxiemeBanniere.index');
    }

    //Fonction pour supprimer 1 image pr�cise
    public function deleteImage(DeuxiemeBanniere $deuxiemeBanniere, $image)
    {

        //On r�cup�re toutes les urls et on les parcours
        $array = $deuxiemeBanniere->getArrayFromUrlsImages();

        for($i = 0; $i < sizeof($array); $i++){

            //D�claration des variables
            $publicId = "";
            $name = "";

            //On d�compose l'url stock�es en DB
            $name = explode("/", $array[$i]);

            //On r�cup�re  le nom de l'image
            $publicId = $name[count($name)-1];

            //On r�cup�re sans l'extension
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
        abort(403);
    }

    //Fonction pour mettre a jour le booleen en DB pour mettre en avant une donn�e
    public function updateOnline(DeuxiemeBanniere $deuxiemeBanniere)
    {
        //On met tous les mod�le � 0
        $all = DeuxiemeBanniere::all();
        foreach ($all as $item){
            $item->online = "0";
            $item->save();
        }

        //On passe le mod�le en cours � 1
        $deuxiemeBanniere->online = 1;
        $response = $deuxiemeBanniere->save();

        if($response){
            return redirect('deuxieme-banniere');
        }
        abort(500);
    }


}
