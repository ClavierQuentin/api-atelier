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


class TroisiemeBanniereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TroisiemeBanniere::all();
        if(sizeof($data) > 0){
            return response()->json($data, 200);
        }
        return response()->json(['status'=> false], 204);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTroisiemeBanniereRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTroisiemeBanniereRequest $request)
    {
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
        $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();
        $path2 = cloudinary()->upload($validated['image2']->getRealPath())->getSecurePath();

        $response = Auth::user()->troisiemeBannieres()->create([
            'titre_principal'=>$request->validated('titre_principal'),
            'titre_1'=>$request->validated('titre_1'),
            'titre_2'=>$request->validated('titre_2'),
            'texte_1'=>$request->validated('texte_1'),
            'texte_2'=>$request->validated('texte_2'),
            'url_image_2'=>$path2,
            'url_image'=>$path
        ]);

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
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function show(TroisiemeBanniere $troisiemeBanniere)
    {
        return response()->json($troisiemeBanniere, 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(TroisiemeBanniere $troisiemeBanniere)
    {
        return response()->json($troisiemeBanniere, 200);
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
        $validator = Validator::make($request->all(),[
            'image'=>[
                File::image()
            ],
            'image2' => [
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

        if(isset($validated['image']) && !isset($validated['image2'])){

            //Suppression de l'ancienne image
            $urlImage = explode("/", $troisiemeBanniere->url_image);
            $publicId = $urlImage[count($urlImage)-1];
            $publicName = explode(".", $publicId)[0];

            $result = Cloudinary::destroy($publicName);

            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

            $update = $troisiemeBanniere->update([
                'titre_principal'=>$request->validated('titre_principal'),
                'titre_1'=>$request->validated('titre_1'),
                'titre_2'=>$request->validated('titre_2'),
                'texte_1'=>$request->validated('texte_1'),
                'texte_2'=>$request->validated('texte_2'),
                'url_image'=>$updatedUrl
            ]);

            if(!$update){
                return response()->json(array('status' => false),500);
            }
            return response()->json(array('status' => true),201);

        }

        if(!isset($validated['image']) && isset($validated['image2'])){
            $urlImage = explode("/", $troisiemeBanniere->url_image_2);
            $publicId = $urlImage[count($urlImage)-1];
            $publicName = explode(".", $publicId)[0];

            $result = Cloudinary::destroy($publicName);

            $updatedUrl = cloudinary()->upload($validated['image2']->getRealPath())->getSecurePath();

            $update = $troisiemeBanniere->update([
                'titre_principal'=>$request->validated('titre_principal'),
                'titre_1'=>$request->validated('titre_1'),
                'titre_2'=>$request->validated('titre_2'),
                'texte_1'=>$request->validated('texte_1'),
                'texte_2'=>$request->validated('texte_2'),
                'url_image_2'=>$updatedUrl
            ]);

            if(!$update){
                return response()->json(array('status' => false),500);
            }
            return response()->json(array('status' => true),201);
        }

        if(isset($validated['image']) && isset($validated['image2'])){
            $urlImage = explode("/", $troisiemeBanniere->url_image);
            $publicId = $urlImage[count($urlImage)-1];
            $publicName = explode(".", $publicId)[0];

            $urlImage2 = explode("/", $troisiemeBanniere->url_image_2);
            $publicId2 = $urlImage2[count($urlImage2)-1];
            $publicName2 = explode(".", $publicId2)[0];


            $result = Cloudinary::destroy($publicName);
            $result2 = Cloudinary::destroy($publicName2);

            $updatedUrl = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();

            $updatedUrl2 = cloudinary()->upload($validated['image2']->getRealPath())->getSecurePath();

            $update = $troisiemeBanniere->update([
                'titre_principal'=>$request->validated('titre_principal'),
                'titre_1'=>$request->validated('titre_1'),
                'titre_2'=>$request->validated('titre_2'),
                'texte_1'=>$request->validated('texte_1'),
                'texte_2'=>$request->validated('texte_2'),
                'url_image_2'=>$updatedUrl2,
                'url_image'=>$updatedUrl
            ]);

            if(!$update){
                return response()->json(array('status' => false),500);
            }
            return response()->json(array('status' => true),201);
        }

        //sinon simple update des textes
        $update = $troisiemeBanniere->update([
            'titre_principal'=>$request->validated('titre_principal'),
            'titre_1'=>$request->validated('titre_1'),
            'titre_2'=>$request->validated('titre_2'),
            'texte_1'=>$request->validated('texte_1'),
            'texte_2'=>$request->validated('texte_2'),
        ]);

        if(!$update){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TroisiemeBanniere  $troisiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(TroisiemeBanniere $troisiemeBanniere)
    {
        //Suppression de l'image sur le cloud
        $urlImage = explode("/", $troisiemeBanniere->url_image);
        $publicId = $urlImage[count($urlImage)-1];
        $publicName = explode(".", $publicId)[0];


        $urlImage2 = explode("/", $troisiemeBanniere->url_image_2);
        $publicId2 = $urlImage2[count($urlImage2)-1];
        $publicName2 = explode(".", $publicId2)[0];

        $result = Cloudinary::destroy($publicName);
        $result2 = Cloudinary::destroy($publicName2);



        $delete = $troisiemeBanniere->delete();
        if(!$delete){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),200);

    }
}
