<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use App\Models\Newsletter;
use Session;
use Mail;
use App\Mail\SendNewsletter;

class UserController extends Controller
{
    //creates a new subscriber
    public function store(Request $request)
    {
        $input = $request->all();
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ])->validate();

        $user = new User;

        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->Save();

        $this->sendWelcomeNewsletter($user);

        if($request->ajax()){        
            
            return ['user' => $user];
        }

        Session::flash('message', "You are subscribed" );
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('home');
    }

    
    //removes a subscriber
    public function destroy($id)
    { 
        $user = User::find($id);
        
        $username = $user->name;
        $user->delete();

        Session::flash('message', "Subscriber (${username}) deleted" );
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('admin.home');
    }

    //implements sending welcome newsletter for new subscriber
    protected function sendWelcomeNewsletter(User $user)
    {
        $title = "welcome to NewsletterApp";
        $description = "we hope we find you in best of your health.Thank you for 
        subscribing .";

        $newsletter = new Newsletter;

        $newsletter->title = $title;
        $newsletter->description = $description;
        $newsletter->Save(); 

        $user->newsletters()->attach($newsletter->id);

        Mail::to($user->email)
        ->send(new SendNewsletter($user->name,true,$title,$description));
    }
}
