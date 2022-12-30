<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Requisition;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $data = [
            'user' => $user,
            'users' => User::all(),
            'requests' => Requisition::where('requester_id',$user->id)->orderBy('id','desc')->get()
        ];

        if (auth()->user()->is_admin == 1) {
            $data['requests'] = Requisition::orderBy('id','desc')->get();  
        }elseif(auth()->user()->is_admin == 2){
            $approved = Requisition::where('status',1)->orderBy('id','desc')->get();
            $resolved = Requisition::where('status',4)->orderBy('id','desc')->get();
            $data['requests'] = $approved->merge($resolved);
            $data['all_requests'] = Requisition::all();
        }
        
        return view('dashboard',$data);
    }
}
