<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\User;
use App\Models\items;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
        $user = User::find($id);

        //$data['requests'] = Requisition::all();
        $data = [
            'user' => $user,
            'users' => User::all(),
            'requests' => Requisition::where('requester_id',$user->id)->get()
        ];


        if ($user->is_admin == 1) {
            $data['requests'] = Requisition::all()->take(9);
            return view('requests',$data);
        }else{
            return view('requests',$data);
        }
        return view('requests',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requestForm');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req = new Requisition();
        $req->title = $request['title'];
        $req->requester = $request['name'];
        $req->requester_id = $request['officer'];
        $req->phone = $request['phone'];
        $req->category = $request['cat'];
        $req->department = $request['department'];
        $req->currency = htmlentities(($request['currency'])); 
        $req->amount =$request['amount']; 
        $req->event =$request['event'];
        $req->zone =$request['zone']; 
        $req->event =$request['cat']; 
        $req->purpose = $request['purpose'];
        $req->email = $request['email'];
        $req->remark = 'Pending';
        $req->status = 0; 
        $req->date = $request['date'];  
        $req->created_at = date('Y-m-d h:m:s');

        $req->save();

        if ($request['cat'] == 2) {
            foreach ($request->moreFields as $value) {
                $value['request_id'] = $req->id;
                $item = new items();
                $item->request_id = $value['request_id'];
                $item->title = $value['title'];
                $item->description = $value['description'];
                $item->qty = $value['qty'];
                $item->price = $value['price'];
                $item->amount = $value['amount'];
                //$item->save();
            }
        }

        return redirect()->route('requests')->with('success', 'Request Has Been Created Successfully.');  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $data['user'] = auth()->user();
        $data['request'] = Requisition::find($id);
        $data['items'] = items::where('request_id',$id);
        //return $data;

        return view('request',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $req = Requisition::find($id);
        $req->title = $request['title'];
        $req->phone = $request['phone'];
        $req->category = $request['cat'];
        $req->department = $request['location'];
        $req->currency =$request['currency']; 
        $req->amount =$request['amount']; 
        $req->event =$request['event'];
        $req->zone =$request['zone']; 
        $req->event =$request['cat']; 
        $req->req_details = $request['purpose'];
        $req->req_officer_id = $_SESSION['user']['id'];
        $req->email = $request['email'];
        $req->remark = 'Pending';
        $req->status = 0;    
        $req->date_created = date('Y-m-d h:m:s');

        $stat = $req->save();

        return redirect()->route('requests');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $req = Requisition::find($id);
        $req->delete();

        return redirect()->route('requests');  
    }

    public function approve($id){
        //Approve Request
        $req = Requisition::find($id);
        $req->status = 1;
        $req->save();

        return redirect()->route('requests');  

    }
    public function decline($id){
        $req = Requisition::find($id);
        $req->status = 2;
        $req->save();

        return redirect()->route('requests');  
        
    }
    public function deny($id){
        $req = Requisition::find($id);
        $req->status = 3;
        $req->save();

        return redirect()->route('requests');  
    }

    public function resolve($id){
        $req = Requisition::find($id);
        $req->status = 4;
        $req->save();

        return redirect()->route('requests');  
    }
}
