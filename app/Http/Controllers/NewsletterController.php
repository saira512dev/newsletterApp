<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\User;
use Validator;
use Session;

class NewsletterController extends Controller
{
    public function index()
    {
        // $subscribers = App\Models\User::all();
    }

    
    public function getByEmail(Request $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255'],
        ])->validate();

        $email = User::where('email', $input['email'])->first();
        if(!$email){
            Session::flash('message', "You are not a subscriber yet,please subscribe" );
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('get.userEmail');

        } else {
            $newsletters = $email->newsletters;
            if(count($newsletters) == NULL){
                Session::flash('message', "You have not recieved any newsletters yet,kindly check later" );
                Session::flash('alert-class', 'alert-danger');

                return redirect()->route('get.userEmail');
            } else {

                return view('pages/list',['newsletters' => $newsletters]);
            }
        }

    }
}
