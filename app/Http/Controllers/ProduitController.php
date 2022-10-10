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
    public function index()
    {
        $produits = Produit::all();
        if(sizeof($produits) > 0){
            return response()->json($produits, 200);
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProduitRequest  $request
     * @param  \App\Models\Categorie $categorie
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduitRequest $request, Categorie $categorie)
    {
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

        $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

        $produit = new Produit($request->validated());

        $produit->url_image_produit = $path;

        $response = $categorie->produits()->save($produit);

        if(!empty($response)){
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
        return response()->json($produit, 200);
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

        if(isset($validated['image'])){

            //Suppression de l'ancienne image
            $urlImage = explode("/", $produit->url_image_produit);
            $publicId = $urlImage[count($urlImage)-1];
            $publicName = explode(".", $publicId)[0];

            $result = Cloudinary::destroy($publicName);

            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

            $produit->url_image_produit = $updatedUrl;

            $update = $produit->update($request->validated());

        } else if(!isset($validated['image'])){
            $update = $produit->update($request->validated());
        }

        if(!$update){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),201);

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
