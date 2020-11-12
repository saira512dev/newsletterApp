<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use Session;

class UserController extends Controller
{
    
    //retrieves all subscribers
    public function index()
    {
        $subscribers = App\Models\User::all();

        
    }

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

        Session::flash('message', "You are subscribed" );
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('home');

    }

    //edits and updates subscriber info
    public function update(Request $request,$id)
    {
        $design = $this->designs->find($id);
        //return $user = $design->user();

        $this->authorize('update', $design,$design);
        
        $this->validate($request,[
            'title' => ['required', 'unique:designs,title,'.$id],
            'description' => ['required','string','min:20', 'max:140'],
            'tags' => ['required'],
            "team" => ['required_if:assign_to_team,true']
        ]);
            

        $design = $this->designs->update($id,[
            "team_id" => $request->team,
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'is_live' => !$design->upload_successfull ? false :$request->is_live
        ]);

        //Apply tags
       $this->designs->applyTags($id,$request->tags);

        return new DesignResource($design);
    }

    //removes a subscriber
    public function destroy($id)
    {
        $design = $this->designs->find($id);
        $this->authorize('delete', $design);

        //delete the files associated with the record
        foreach(['thumbnail','large','original'] as $size){
            //check if the file exists
            if(Storage::disk($design->disk)->exists("uploads/designs/{$size}/".$design->image)){
                Storage::disk($design->disk)->delete("uploads/designs/{$size}/".$design->image);
            }
        }

        $this->designs->delete($id);

        return response()->json(["message" => "Record deleted"], 200);

    }
}
