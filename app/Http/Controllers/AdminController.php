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

class AdminController extends Controller
{
    //retrieves all subscribers
    public function index()
    {
        $users = User::paginate(5);

        return view('pages/admin/home',['users' => $users]);
    }

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

        return ['user' => $user];
    }

    //edits and updates subscriber info
    public function update(Request $request,$id)
    {
        $user = User::find($id);

        $this->validate($request,[
            'email' => ['required', 'unique:users,email,'.$id],
            'name' => ['required','string', 'max:255'],
        ]);
            

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return ['user' => $user];

    }

    protected function sendWelcomeNewsletter(User $user)
    {
        $newsletter = new Newsletter;

        $title = "welcome to NewsletterApp";
        $description = "we hope we find you in best of your health.Thank you for 
        subscribing .";

        $newsletter->title = $title;
        $newsletter->description = $description;
        $newsletter->Save(); 

        $user->newsletters()->attach($newsletter->id);
        
        Mail::to($user->email)
        ->send(new SendNewsletter($user->name,true,$title,$description));

    }

    
}
