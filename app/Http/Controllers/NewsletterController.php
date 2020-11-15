<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\User;
use Validator;
use Session;
use Mail;
use App\Mail\SendNewsletter;

class NewsletterController extends Controller
{
    public function index()
    {
        // $subscribers = App\Models\User::all();
    }

    public function store(Request $request)
    {
        $input = $request->all();
        Validator::make($input, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'min:20','max:2000'],
        ])->validate();

        $newsletter = new Newsletter;

        $newsletter->title = $input['title'];
        $newsletter->description = $input['description'];
        $newsletter->Save();

        $users = User::all();
        if(!$users->isEmpty()){
            foreach($users as $user){

                $user->newsletters()->attach($newsletter->id);
            
                Mail::to($user->email)
                ->send(new SendNewsletter($user->name,false,$newsletter->title,$newsletter->description));
    
            }
    
            Session::flash('message', "Newsletter published and sent to all subscribers" );
            Session::flash('alert-class', 'alert-success');
    
        } else {
            Session::flash('message', "Newsletter published ,no subscribers yet " );
            Session::flash('alert-class', 'alert-success');
        }
        
        return redirect()->route('admin.create.newsletter');
    }

    
    public function getByEmail(Request $request)
    {
        $input = $request->all();

        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255'],
        ])->validate();

        $user = User::where('email', $input['email'])->first();
        if(!$user){
            Session::flash('message', "You are not a subscriber yet,please subscribe" );
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('get.userEmail');

        } else {
            $newsletters = $user->newsletters;
            if(count($newsletters) == NULL){
                Session::flash('message', "You have not recieved any newsletters yet,kindly check later" );
                Session::flash('alert-class', 'alert-danger');

                return redirect()->route('get.userEmail');
            } else {

                return view('pages/subscriber/list',['newsletters' => $newsletters]);
            }
        }

    }
}
