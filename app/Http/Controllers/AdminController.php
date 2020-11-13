<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use Session;

class AdminController extends Controller
{
    //retrieves all subscribers
    public function index()
    {
        $users = User::all();

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

        return redirect()->route('admin.home');

    }

    //edits and updates subscriber info
    public function update(Request $request,$id)
    {
       return  $user = User::find($id);

        
        $this->validate($request,[
            'email' => ['required', 'unique:users,email,'.$id],
            'name' => ['required','string', 'max:255'],
        ]);
            

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return redirect()->route('admin.home');
    }

    
}
