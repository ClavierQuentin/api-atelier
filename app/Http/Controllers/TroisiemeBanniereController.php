<?php

namespace App\Http\Controllers;

use App\Models\TroisiemeBanniere;
use App\Http\Requests\StoreTroisiemeBanniereRequest;
use App\Http\Requests\UpdateTroisiemeBanniereRequest;
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
        $troisiemeBannieres = TroisiemeBanniere::all();

        if(isset($troisiemeBannieres)){
            return view('troisiemeBannieres.index',['troisiemeBannieres' => $troisiemeBannieres]);
        }
        abort(500);
    }

    //Controller pour l'API cot� Front
    public function indexApi()
    {
        $troisiemeBanniere = DB::table('troisieme_bannieres')
                        ->where('online', '=', '1')
                        ->first();
        if(isset($troisiemeBanniere)){
            return response()->json($troisiemeBanniere, 200);
        }
        return response()->json(['status'=> false],404);

    }

    //Direction pour le formulaire de création
    public function create()
    {
        return view('troisiemeBannieres.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTroisiemeBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTroisiemeBanniereRequest $request)
    {
        //Règles de validation du fichier
        $validator = Validator::make($request->all(),[
            'image'=>[
                'required',
                File::image()
            ],
            'image2'=>[
                'required',
                File::image()
            ]
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Une erreur est survenue',
                'errors'=>$validator->errors()
            ],401);
        };

        $validated = $validator->validated();

        //On upload chaque image
        $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

        $path2 = cloudinary()->upload($validated['image2']->getRealPath())->getSecurePath();
        //Création du nouvel objet
        $troisiemeBanniere = new TroisiemeBanniere($request->validated());


        //On enregistre certain paramètres
        $troisiemeBanniere->url_image = $path;
        $troisiemeBanniere->url_image_2 = $path2;

        //Enregistrement en DB
        $response = Auth::user()->troisiemeBannieres()->save($troisiemeBanniere);

        if($response){
            return redirect('troisieme-banniere');
        }
        return redirect('troisieme-banniere')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    // public function show()
    // {
    //     $troisiemeBanniere = DB::table('troisieme_bannieres')
    //                     ->where('online', '=', '1')
    //                     ->first();
    //     return response()->json($troisiemeBanniere, 200);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(TroisiemeBanniere $troisiemeBanniere)
    {
        return view('troisiemeBannieres.edit',['troisiemeBanniere'=>$troisiemeBanniere]);
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
        //Regle de validation du fichier image
        $validator = Validator::make($request->all(),[
            'image'=>[
                File::image()
            ],
            'image2' => [
                File::image()
            ]
        ]);
        //Sortie et erreur en cas de non validation
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Une erreur est survenue',
                'errors'=>$validator->errors()
            ],401);
        };

        //R�cup�ration des donn�e valid�es
        $validated = $validator->validated();

        //Si une image a �t� fournie au formulaire pour la 1ere image
        if(isset($validated['image']) && !isset($validated['image2'])){

            //Suppression de l'ancienne image
            $troisiemeBanniere->deleteImage1();
            //Upload de la nouvelle image
            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

            //Enregistrement de la nouvelle URL
            $troisiemeBanniere->url_image = $updatedUrl;

        }

        //Si une image a �t� fournie au formulaire pour la deuxieme image
        if(!isset($validated['image']) && isset($validated['image2'])){

            //Suppression de l'image actuelle
            $troisiemeBanniere->deleteImage2();

            //Enregistrement au cloud et r�cup�ration de l'url
            $updatedUrl = cloudinary()->upload($validated['image2']->getRealPath())->getSecurePath();

            //On enregistre la nouvelle url
            $troisiemeBanniere->url_image_2 = $updatedUrl;
        }

        //Si les 2 images ont �t� envoy�es au formulaire
        if(isset($validated['image']) && isset($validated['image2'])){

            //On supprime les images existantes
            $troisiemeBanniere->deleteImage1();
            $troisiemeBanniere->deleteImage2();

            //On enregistre les nouvelles images et on r�cup�re les urls
            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();
            $updatedUrl2 = cloudinary()->upload($validated['image2']->getRealPath())->getSecurePath();

            //On enregistre les urls
            $troisiemeBanniere->url_image = $updatedUrl;
            $troisiemeBanniere->url_image_2 = $updatedUrl2;
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
        foreach ($all as $item){
            $item->online = "0";
            $item->save();
        }

        $troisiemeBanniere->online = 1;
        $troisiemeBanniere->save();

        return redirect('troisieme-banniere');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(TroisiemeBanniere $troisiemeBanniere)
    {
        //Suppression des images sur le cloud
        $troisiemeBanniere->deleteImage1();
        $troisiemeBanniere->deleteImage2();

        $delete = $troisiemeBanniere->delete();
        if(!$delete){
            abort(500);
        }
        return view('troisiemeBannieres.index');

    }
}
