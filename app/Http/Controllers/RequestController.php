<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\User;
use App\Model\Document;
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

        $data = [
            'user' => $user,
            'users' => User::all(),
            'requests' => Requisition::where('requester_id',$user->id)->orderBy('id','desc')->get()
        ];


        if ($user->is_admin == 1) {
            $data['requests'] = Requisition::orderBy('id','desc')->get();
            return view('requests',$data);
        }
        elseif ($user->is_admin == 2) {
           $approved = Requisition::where('status',3)->orderBy('id','desc')->get();
            $resolved = Requisition::where('status',4)->orderBy('id','desc')->get();
            $data['requests'] = $approved->merge($resolved);
            $data['all_requests'] = Requisition::orderBy('id','desc')->get();
           
            return view('requests',$data);
        }elseif ($user->is_admin == 3) {
            $approved = Requisition::where('status',0)->orderBy('id','desc')->get();
            $resolved = Requisition::where('status',1)->orderBy('id','desc')->get();
            $data['requests'] = $approved->merge($resolved);
            $data['all_requests'] = Requisition::orderBy('id','desc')->get();
           
            return view('requests',$data);
        }elseif ($user->is_admin == 4) {
           $approved = Requisition::where('status',1)->orderBy('id','desc')->get();
            $resolved = Requisition::where('status',2)->orderBy('id','desc')->get();
            $data['requests'] = $approved->merge($resolved);
            $data['all_requests'] = Requisition::orderBy('id','desc')->get();
           
            return view('requests',$data);
        }elseif ($user->is_admin == 5) {
           $approved = Requisition::where('status',2)->orderBy('id','desc')->get();
            $resolved = Requisition::where('status',3)->orderBy('id','desc')->get();
            $data['requests'] = $approved->merge($resolved);
            $data['all_requests'] = Requisition::orderBy('id','desc')->get();
           
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
        return $request;
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
        $req->purpose = $request['purpose'];
        $req->email = $request['email'];
        $req->remark = 'Pending';
        $req->status = 0; 
        $req->date = strtotime($request['date']);  
        $req->created_at = date('Y-m-d h:m:s');

        $req->save();
        
        $amount = 0;

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
                $item->save();
                $amount = $amount + $item->amount;
            }
            
            $reqq = $req = Requisition::find($req->id);
            $reqq->amount = $amount;
            $reqq->save();
        }
        
        // Get the uploaded files
        $documents = $request->file('documents');
        
        // Process each uploaded file
        foreach ($documents as $document) {
            $fileName = uniqid() . '.' . $document->extension();
            
            $document->storeAs('documents', $fileName);
            
            Document::create([
                'request_id' => $req->id,
                'name' => $fileName,
                'original_name' => $document->getClientOriginalName(),
                'size' => $document->getSize(),
                'mime_type' => $document->getMimeType()
            ]);
        }

        
        

        return redirect()->route('requests')->with('success', 'Your Request Has Been Submitted Successfully pending approval');  
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

        $data['user'] = auth()->user();
        $data['request'] = Requisition::find($id);
        $data['items'] = items::where('request_id',$id);
        //return $data;

        return view('request',$data);
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
        $req->phone = $request['phone'];
        $req->category = $request['cat'];
        $req->department = $request['department'];
        $req->currency = empty($request['currency']) ? $req->currency : $request['currency']; 
        $req->amount =$request['amount']; 
        $req->event =$request['event'];
        $req->zone =$request['zone']; 
        $req->purpose = $request['purpose'];
        $req->email = $request['email'];
        $req->remark = 'Edited';
        $req->status = 0;    
        $req->updated_at = date('Y-m-d h:m:s');

        $stat = $req->save();

        return redirect()->route('requests')->with('success', 'Request Has Been Created Successfully.');  
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

        return redirect()->route('requests')->with('success', 'Request Has Been deleted Successfully.');  
    }

    public function approved(){
        
        $data['requests'] = Requisition::where('status',1)->orderBy('id','desc')->get();
        $data['all_requests'] = Requisition::all();
        return view('requests',$data);  

    }
    public function approve(Request $request){
        //Approve Request
        $id = $request['id'];
        $req = Requisition::find($id);
        $req->status = 1;
        $req->remark = 'Approved';
        $req->save();

        return redirect()->route('requests')->with('success', 'Request Has Been approved Successfully.');  

    }
    public function decline(Request $request){
        $id = $request['id'];
        $req = Requisition::find($id);
        $req->status = 2;
        $req->remark = $request['remark'];
        $req->save();

        return redirect()->route('requests')->with('success', 'Request Has Been declined Successfully.');  
        
    }

    public function declined(){
        $data['requests'] = Requisition::where('status',2)->get();
        return view('requests',$data);  
    }

    public function deny(Request $request){
        $id = $request['id'];
        $req = Requisition::find($id);
        $req->remark = $request['remark'];
        $req->status = 3;
        $req->save();
        return redirect()->route('requests')->with('success', 'Request Has Been denied Successfully.');  
    }

    public function denied(){
        $data['requests'] = Requisition::where('status',3)->get();
        return view('requests',$data);  
    }

    public function resolve(Request $request){
        $id = $request['id'];
        $req = Requisition::find($id);
        $req->status = 4;
        $req->save();

        return redirect()->route('requests')->with('success', 'Request Has Been resolved Successfully.');  
    }

    public function resolved(){
        $data['all_requests'] = Requisition::all();
        $data['requests'] = Requisition::where('status',4)->orderBy('id','desc')->get();
        return view('requests',$data);  
    }
}
