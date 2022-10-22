<?php

namespace App\Http\Controllers;

use App\Models\PremiereBanniere;
use App\Http\Requests\StorePremiereBanniereRequest;
use App\Http\Requests\UpdatePremiereBanniereRequest;
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
        return view('premiereBannieres.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePremiereBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePremiereBanniereRequest $request)
    {
        //Règles de validation
        $validator = Validator::make($request->all(),[
            'image'=>[
                'required',
                File::image()
            ]
        ]);
        if($validator->fails()){
            return redirect('premiere-banniere')->with('error', $validator->errors());
        };

        $validated = $validator->validated();

        //ON enregistre l'image au cloud en récupérant l'url d'acces
        $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

        //CRéation d'un nouvel objet
        $premiereBanniere = new PremiereBanniere($request->validated());

        //on enregistre le chemin d'acces de l'image
        $premiereBanniere->url_image = $path;

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
        return view('premiereBannieres.edit',['premiereBanniere'=>$premiereBanniere]);
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
        //Regle de validation du fichier image
        $validator = Validator::make($request->all(),[
            'image'=>[
                File::image()
            ]
        ]);
        //Sortie et erreur en cas de non validation
        if($validator->fails()){
            if($validator->fails()){
                return redirect('premiere-banniere')->with('error', $validator->errors());
            };
        };

        //Récupération des données validées
        $validated = $validator->validated();

        //Si une image a été fournie au formulaire
        if(isset($validated['image'])){

            //Suppression de l'ancienne image
            $premiereBanniere->deleteImage();

            //Upload de la nouvelle image
            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

            //Enregistrement de la nouvelle URL
            $premiereBanniere->url_image = $updatedUrl;
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
        //Suppression de l'image sur le cloud, voir Model
        $premiereBanniere->deleteImage();

        //Suppression en BDD
        $delete = $premiereBanniere->delete();

        if(!$delete){
            abort(500);
        }
        return redirect('premiere-banniere');
    }


}
