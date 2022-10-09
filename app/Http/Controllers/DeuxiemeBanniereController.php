<?php

namespace App\Http\Controllers;

use App\Models\DeuxiemeBanniere;
use App\Http\Requests\StoreDeuxiemeBanniereRequest;
use App\Http\Requests\UpdateDeuxiemeBanniereRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DeuxiemeBanniereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DeuxiemeBanniere::all();
        if(sizeof($data) > 0){
            return response()->json($data, 200);
        }
        return response()->json(['status'=> false], 204);
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
        foreach($request->file('image') as $file){
            $validator = Validator::make($file,[
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
            $data[] = $path;
        }

        $response = Auth::user()->deuxiemeBannieres()->create([
            'titre'=>$request->validated('titre'),
            'texte'=>$request->validated('texte'),
            'url_image'=>json_encode($data)
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
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function show(DeuxiemeBanniere $deuxiemeBanniere)
    {
        return response()->json($deuxiemeBanniere, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function edit(DeuxiemeBanniere $deuxiemeBanniere)
    {
        return response()->json($deuxiemeBanniere, 200);
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
        foreach($request->file('image') as $file){
            $validator = Validator::make($file,[
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
            $path = cloudinary()->upload($validated['image']->getRealPath())->getSecurePath();
            $data[] = $path;
        }

        if(sizeof($data) > 0) {
            $urls = $deuxiemeBanniere->getArrayFromUrlsImages();
            foreach($urls as $url) {
                $urlImage = explode("/", $url);
                $publicId = $urlImage[count($urlImage)-1];
                $publicName = explode(".", $publicId)[0];

                $result = Cloudinary::destroy($publicName);
            }
            $response = $deuxiemeBanniere->update([
                'titre'=>$request->validated('titre'),
                'texte'=>$request->validated('texte'),
                'url_image'=>json_encode($data)
            ]);

            if(!$response){
                return response()->json(array('status' => false),500);
            }
            return response()->json(array('status' => true),201);

        }

        $update = $deuxiemeBanniere->update($request->validated());
        if(!$update){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeuxiemeBanniere  $deuxiemeBanniere
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeuxiemeBanniere $deuxiemeBanniere)
    {
        $urls = $deuxiemeBanniere->getArrayFromUrlsImages();
        foreach($urls as $url) {
            $urlImage = explode("/", $url);
            $publicId = $urlImage[count($urlImage)-1];
            $publicName = explode(".", $publicId)[0];

            $result = Cloudinary::destroy($publicName);
        }

        $delete = $deuxiemeBanniere->delete();
        if(!$delete){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),200);
    }
}
