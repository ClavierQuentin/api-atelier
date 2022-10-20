<?php

namespace App\Http\Controllers;

use App\Models\ListEmail;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends Controller
{
    public function sendEmails(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'titre' => 'required|string',
            'body'=> 'required|string'
        ]);
        if($validator->fails()){
            abort(500);
        }

        $validated = $validator->validated();

        $newsletter = new Newsletter($validated);

        Auth::user()->newsletter()->save($newsletter);

        $users = ListEmail::all();

        $mails_adress = array();

        foreach($users as $user){
            $mails_adress[] = $user->email;
        }

        // $details = ['message'=>'test'];




        Mail::to($mails_adress)
        ->send(new \App\Mail\Newsletter($newsletter));


    }

    public function create()
    {
        return view('newsletter.create');
    }
}
