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
            'requests' => Requisition::where('requester_id',$user->id)->get()
        ];

        if (auth()->user()->is_admin == 1) {
            $data['requests'] = Requisition::all();  
        }

        return view('dashboard',$data);
    }
}
