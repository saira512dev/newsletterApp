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
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
            'description' => ['required', 'min:20','max:5000'],
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
                $newsletters = $this->paginate($newsletters);
                $newsletters->setPath('/newsletters');
                $newsletters->appends(['email' => $input['email']]);
                return view('pages/subscriber/list',['newsletters' => $newsletters]);
            }
        }

    }


    protected function paginate($items, $perPage = 3, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
