<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use Carbon\Carbon;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::all();
        if(sizeof($categories) > 0){
            return response()->json($categories, 200);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategorieRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategorieRequest $request)
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

        $categorie = new Categorie($request->validated());

        $categorie->url_image_categorie = $path;

        $response = Auth::user()->categories()->save($categorie);

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
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    {
        return response()->json($categorie, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        return response()->json($categorie, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategorieRequest  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
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
            $urlImage = explode("/", $categorie->url_image_categorie);
            $publicId = $urlImage[count($urlImage)-1];
            $publicName = explode(".", $publicId)[0];

            $result = Cloudinary::destroy($publicName);

            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

            $categorie->url_image_categorie = $updatedUrl;

            $update = $categorie->update($request->validated());
        } else if(!isset($validated['image'])){
            $update = $categorie->update($request->validated());
        }

        if(!$update){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        //Suppression de l'image sur le cloud
        $urlImage = explode("/", $categorie->url_image_categorie);
        $publicId = $urlImage[count($urlImage)-1];
        $publicName = explode(".", $publicId)[0];

        $result = Cloudinary::destroy($publicName);

        //Suppression en DB
        $delete = $categorie->delete();
        if(!$delete){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),200);
    }

    /**
     * Show all products from same category.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function getAllProducts(Categorie $categorie)
    {
        $produits = $categorie->getProduits;

        if(sizeof($produits) > 0){
            return response()->json($produits, 200);
        }
    }
}
