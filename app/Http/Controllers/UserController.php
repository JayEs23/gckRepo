<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $data['users'] = User::all();
        return view('users.index',$data);
    }

    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = new User();
        $user->name = $request['name'];
        $user->phone = $request['phone'];
        $user->is_admin = $request['is_admin'];
        $user->password = Hash::make($request['password']); 
        $user->email = $request['email'];
        $user->created_at = date('Y-m-d h:m:s');
        $user->save();

        return redirect()->route('users')->with('success', 'User Has Been Created Successfully.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['user'] = User::find($id);
        return view('users.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user'] = User::find($id);
        return view('users.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req = User::find($id);
        $user->name = $request['name'];
        $user->phone = $request['phone'];
        $user->is_admin = $request['is_admin'];
        $user->email = $request['email'];
        $user->created_at = date('Y-m-d h:m:s');
        $user->save();

        return redirect()->route('users')->with('success', 'User Has Been updated Successfully.');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::Find($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'User Has Been deleted Successfully.');  
    }

    public function makeAdmin($id){
        $req = User::Find($id);
        $user->is_admin = 1;
        $user->save();

        return redirect()->route('users')->with('success', 'User Has Been updated Successfully.');  

    }
    public function makeAccount($id){
        $req = User::Find($id);
        $user->is_admin = 2;
        $user->save();

        return redirect()->route('users')->with('success', 'User Has Been updated Successfully.');  
        
    }
    public function makeUser($id){
        $req = User::Find($id);
        $user->is_admin = 0;
        $user->save();

        return redirect()->route('requests')->with('success', 'User Has Been updated Successfully.');  
    }
}