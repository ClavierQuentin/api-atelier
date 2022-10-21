<?php

namespace App\Http\Controllers;

use App\Models\ListEmail;
use App\Http\Requests\StoreListEmailRequest;
use App\Http\Requests\UpdateListEmailRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ListEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreListEmailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListEmailRequest $request)
    {
        //Récupération du Token google côté client pour le faire vérifier
        $recaptchaToken = $request['token'];
        $secretKey = env('SECRET_KEY');

        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$recaptchaToken);

        if($response->failed()){
            return response()->json(['status' => 'false', 'errors'=>$response], 500);
        }

        //Si captcha OK et honeypot vide, on procèe à la suite
        if($response->ok() && $request['pot'] == NULL){

            $item = new ListEmail($request->validated());

            $saved = $item->save();

            if($saved){
                return response()->json(['status' => true], 201);
            }
            return response()->json(['status' => false], 404);

        }

        return response()->json(['status' => false], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function show(ListEmail $listEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('newsletter.edit_email');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateListEmailRequest  $request
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateListEmailRequest $request, ListEmail $listEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string'
        ]);
        if($validator->fails()){
            abort(500);
        }

        $validated = $validator->validated();

        $listEmail = DB::table('list_emails')
                    ->where('email', '=', $validated['email'])
                    ->first();
        $listEmail = ListEmail::find($listEmail->id);

       $delete =  $listEmail->delete();
       if($delete){
        return view('newsletter.delete');
       }
       abort(404);
    }
}
