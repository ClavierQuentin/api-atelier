<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Http\Requests\StoreProduitRequest;
use App\Http\Requests\UpdateProduitRequest;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use PDO;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexApi()
    {
        $produits = Produit::all();
        if(sizeof($produits) > 0){
            return response()->json($produits, 200);
        }
    }

    public function index()
    {
        $produits = Produit::all();
        return view('produits.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function productFromSameCategorie(Produit $produit)
    {
        $categorie = Categorie::find($produit->categorie_id);

        $produits = $categorie->getProduits;

        if(sizeof($produits) > 0){
            return response()->json($produits, 200);
        }
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('produits.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProduitRequest  $request
     * @param  \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduitRequest $request, Categorie $categorie)
    {
        //Regles de validation pour l'image d'illustration
        $validator = Validator::make($request->all(),[
            'image'=>[
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

        //Upload de l'image sur le cloud
        $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

        //On instancie un nouvel objet Produit avec la requete du formulaire
        $produit = new Produit($request->validated());

        //Enregistrement du chemin d'acces de l'image
        $produit->url_image_produit = $path;

        //Enregistrement en DB
        $response = $categorie->produits()->save($produit);

        //On contrôle le résultat de sortie
        //On contrôle la sortie, si l'update a bien été faite
        if(empty($response)){
            return redirect('categorie/'.$produit->categorie_id.'/produits')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
        }
        return redirect('categorie/'.$produit->categorie_id.'/produits');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        return response()->json($produit, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
         $categories = Categorie::all();
        return view('produits.edit', compact('produit','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProduitRequest  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProduitRequest $request, Produit $produit)
    {
        //Regle de validation du fichier image
        $validator = Validator::make($request->all(),[
            'image'=>[
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

        //Si une image a été fournie au formulaire
        if(isset($validated['image'])){

            //Suppression de l'ancienne image
            $urlImage = explode("/", $produit->url_image_produit);
            $publicId = $urlImage[count($urlImage)-1];
            $publicName = explode(".", $publicId)[0];

            $result = Cloudinary::destroy($publicName);

            //Upload de la nouvelle image
            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

            //CHangement de l'url de l'image
            $produit->url_image_produit = $updatedUrl;
        }

        //Cas où la checbox n'est pas cochée
        if($request->isAccueil == NULL){
            $produit->isAccueil = 0;
        }

        //Enregistrement des changements en DB
        $update = $produit->update($request->validated());

        //On contrôle la sortie, si l'update a bien été faite
        if(!$update){
            return redirect('categorie/'.$produit->categorie_id.'/produits')->with('error', 'Une erreur est survenue pendant l\'enregistrement');
        }
        return redirect('categorie/'.$produit->categorie_id.'/produits');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        // //Suppression de l'image sur le cloud
        // $urlImage = explode("/", $produit->url_image_produit);
        // $publicId = $urlImage[count($urlImage)-1];
        // $publicName = explode(".", $publicId)[0];

        // $result = Cloudinary::destroy($publicName);

        //Suppression en DB
        $delete = $produit->delete();
        if(!$delete){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),200);

    }


}
