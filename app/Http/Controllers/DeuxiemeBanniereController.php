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

        // $validator = Validator::make($request->all(),[
        //     'image'=>[
        //         'required',
        //         File::image()
        //     ]
        // ]);
        // if($validator->fails()){
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>'Une erreur est survenue',
        //         'errors'=>$validator->errors()
        //     ],401);
        // };

        $this->validate($request ,[
            'image'=>'required',
            'image.*'=>'mimes:jpg,jepg,png,JPG,JPEG'
        ]);

        foreach($request->file('image') as $file){
            $path = cloudinary()->upload($file->getRealPath())->getSecurePath();
            $data[] = $path;
        }

        $deuxiemeBanniere = new DeuxiemeBanniere($request->validated());

        $deuxiemeBanniere->url_image = json_encode($data);

        $response = Auth::user()->deuxiemeBannieres()->save($deuxiemeBanniere);

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

        $this->validate($request ,[
            'image'=>'required',
            'image.*'=>'mimes:jpg,jepg,png,JPG,JPEG'
        ]);


        foreach($request->file('image') as $file){
            $path = cloudinary()->upload($file->getRealPath())->getSecurePath();
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

            $deuxiemeBanniere->url_image = $data;
        }

        $update = $deuxiemeBanniere->update($request->validated());

        if(!$update){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),201);
    }

    public function addImage(DeuxiemeBanniere $deuxiemeBanniere, UpdateDeuxiemeBanniereRequest $request)
    {
        $data = array();

        $this->validate($request ,[
            'image'=>'required',
            'image.*'=>'mimes:jpg,jepg,png,JPG,JPEG'
        ]);


        foreach($request->file('image') as $file){
            $path = cloudinary()->upload($file->getRealPath())->getSecurePath();
            $data[] = $path;
        }

        $oldData = json_decode($deuxiemeBanniere->url_image);

        $newData = array_merge($oldData, $data);

        $deuxiemeBanniere->url_image = json_encode($newData);

        $response = $deuxiemeBanniere->save();

        if(!$response){
            return response()->json(['status'=>false], 500);
        }
        return response()->json(['status'=>true], 200);
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

    public function deleteImage(DeuxiemeBanniere $deuxiemeBanniere, UpdateDeuxiemeBanniereRequest $request)
    {
        $oldData = json_decode($deuxiemeBanniere->url_image);

        $data = $request->validated();

        if(sizeof($oldData) > sizeof($data)){
            for($i = 0; $i < sizeof($oldData); $i++){
                for($j = 0; $j < sizeof($data); $j++){
                    if($oldData[$i] == $data[$j]){
                        $urlImage = explode("/", $oldData[$i]);
                        $publicId = $urlImage[count($urlImage)-1];
                        $publicName = explode(".", $publicId)[0];

                        $result = Cloudinary::destroy($publicName);

                        array_splice($oldData, $i, 1);
                    }
                }
            }
        } else if(sizeof($oldData) > sizeof($data)) {
            for($i = 0; $i < sizeof($data); $i++){
                for($j = 0; $j < sizeof($oldData); $j++){
                    if($data[$i] == $oldData[$j]){
                        $urlImage = explode("/", $oldData[$j]);
                        $publicId = $urlImage[count($urlImage)-1];
                        $publicName = explode(".", $publicId)[0];

                        $result = Cloudinary::destroy($publicName);

                        array_splice($oldData, $j, 1);
                    }
                }
            }

        }

        $deuxiemeBanniere->url_image = json_encode($oldData);

        $delete = $deuxiemeBanniere->save();

        if(!$delete){
            return response()->json(array('status' => false),500);
        }
        return response()->json(array('status' => true),200);
    }
}
