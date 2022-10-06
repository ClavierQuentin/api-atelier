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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        // $uploadedFileUrl = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();
        $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();
        $path .= Carbon::now()->timestamp.'_';
        // $path = $validated['image']->storeAs('images_categories', Carbon::now()->timestamp.'_'.$request->file('image')->getClientOriginalName(), ['disk'=>'public']);

        $response = Auth::user()->categories()->create([
            'nom_categorie'=>$request->validated('nom_categorie'),
            'url_image_categorie'=>$path
        ]);

        //Trouver comment utiliser file_exists

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        //
    }

    public function upload(StoreCategorieRequest $request)
    {
        // $uploadedFileUrl = Cloudinary::upload($request->file('file')->getRealPath());
        // $result = $request->file('file')->storeOnCloudinary();
        $uploadedFileUrl = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();
        return response()->json($uploadedFileUrl);
    }
}
