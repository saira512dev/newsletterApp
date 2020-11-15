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
    
}
