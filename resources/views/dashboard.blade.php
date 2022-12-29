@extends('layouts.app')
<?php
    $resolved = [];
    $approved = [];
    $declined = [];
    $denied = [];
    $pending = [];

    foreach ($requests as $request) {
        if ($request->status == 0) {
            $pending[] = $request;
        }
        else if ($request->status == 1) {
            $approved[] = $request;
        }
        else if ($request->status == 2) {
            $denied[] = $request;
        }
        else if ($request->status == 3) {
            $declined[] = $request;
        }
        else if ($request->status == 4) {
            $resolved[] = $request;
        }
    }

    function status($value)
    {
        $stat = '';
        switch ($value) {
          case "1":
            $stat = '<span class="btn btn-sm btn-info">Approved</span>';
            break;
          case "2":
            $stat = '<span class="btn btn-sm btn-danger">Declined</span>';
            break;
          case "3":
            $stat = '<span class="btn btn-sm btn-dark">Denied</span>';
            break;
            case "4":
            $stat = '<span class="btn btn-sm btn-success">Resolved</span>';
            break;
          default:
            $stat = '<span class="btn btn-sm btn-warning">Pending</span>';
        }
        return $stat;
    }


?>

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7" >
        <div class="row mt-5" style="min-height:400px !important">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Requisition History</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('requests')}}" class="btn btn-sm btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @if(count($requests) > 0)
                                @foreach($requests as $req)
                                <tr>
                                    <th scope="row">
                                        {{$req->title}}
                                    </th>
                                    <td>
                                        <span> <?php echo status($req->status) ?></span>
                                    </td>
                                    <td>
                                        {{$req->date}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal{{$req->id}}" data-placement="left" title="View Request Details"><i class="fas fa-eye"></i></button>
                                        <a class="btn btn-dark btn-sm" href="{{ route('requests.show',$req->id) }}" data-placement="left" title="Edit Request"><i class="fas fa-edit"></i></a>
                                        @if(auth()->user()->is_admin == 2)
                                        <a class="btn btn-success btn-sm" href="{{ route('requests.resolve',$req->id) }}" data-placement="left" title="Resolve Request"><i class="fas fa-check"></i></a>
                                         <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#decline{{$req->id}}"  data-placement="left" title="Decline"><i class="fas fa-check"></i></button>
                                        @endif
                                        @if(auth()->user()->is_admin == 1)
                                         <a class="btn btn-success btn-sm" href="{{ route('requests.approve',$req->id) }}" data-placement="left" title="Approve"><i class="fas fa-check"></i></a>
                                         <a class="btn btn-danger btn-sm" href="{{ route('requests.deny',$req->id) }}" data-placement="left" title="Deny Request"><i class="fas fa-times-circle"></i></a>
                                        @endif
                                        
                                         
                                    </td>
                                    <div class="modal fade" id="decline{{$req->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$user->name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <form method="post" action="../requests/decline">
                                                @csrf
                                                <div class="modal-body">


                                                <h3>Type Reason for Declining </h3>
                                                <input type="text" name="remark" class="form-control" required>
                                                <input type="hidden" name="id" value="{{$req->id}}" class="form-control" required>
                                                <button class="btn btn-danger mt-5">Decline</button>
                                              </div>
                                              </form>
                                             
                                              <div class="modal-footer">
                                               
                                                 
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                </tr>
                                <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{$req->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">{{$req->title}}</h3>
                                            
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <label>Title : <span><b>{{$req->title}}</b></span></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Requester : <span><b>{{$req->requester}}</b></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Phone : <span><b>{{$req->phone}}</b></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Email : <span><b>{{$req->email}}</b></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Department : <span><b>{{$req->department}}</b></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Purpose : <span><b>{{$req->purpose}}</b></span></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Location/Zone : <span><b>{{$req->zone}}</b></span></label>
                                                </div>
                                                
                                                <div class="col-xl-6">
                                                    <label>Program/Event : <span><b>{{$req->event}}</b></span></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Currency : <span><b>{!!$req->currency!!}</b></span></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Amount : <span><b>{{number_format($req->amount)}}</b></span></label>
                                                </div>
                                                
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                @endforeach
                            @endif   
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush