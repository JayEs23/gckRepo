@extends('layouts.app')

@section('content')
    
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-xl-3 mt-2">
                    <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('Requisition List') }}</a>
                </div>
                <div class="col-xl-9 mt-2">
                    <div class="row">
                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif
                </div>
                </div>
                 
            </div>
            <div class="header-body">
                <!-- Card stats -->
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Requests</h5>
                                    <span class="h2 font-weight-bold mb-0">{{count($requests)}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                @if(auth()->user()->is_admin != 0)
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Pending</h5>
                                    <span class="h2 font-weight-bold mb-0">2</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Approved</h5>
                                    <span class="h2 font-weight-bold mb-0">4</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                @endif
                @if(auth()->user()->is_admin == 1)
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Users</h5>
                                    <span class="h2 font-weight-bold mb-0">{{count($users)}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
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
                                <a href="{{ route('requests.create') }}" class="btn btn-sm btn-dark">New Request</a>
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
                                        <span {{$req->remark}}</span>
                                    </td>
                                    <td>
                                        {{$req->date}}
                                    </td>
                                    <td>
                                        <form action="{{ route('requests.destroy',$req->id) }}" method="Post">
                                            <a class="btn btn-primary" href="{{ route('requests.show',$req->id) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$req->id}}">View</button>
                                         
                                    </td>
                                </tr>
                                <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{$req->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{$req->title}}</h5>
                                            
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <label>Title : <span><b>{{$req->title}}</b></span></label>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Requester : <span><b>{{$req->requester}}</b></label>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Phone : <span><b>{{$req->phone}}</b></label>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Email : <span><b>{{$req->email}}</b></label>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Department : <span><b>{{$req->department}}</b></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Purpose : <span><b>{{$req->purpose}}</b></span></label>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Location/Zone : <span><b>{{$req->zone}}</b></span></label>
                                                </div>
                                                
                                                <div class="col-xl-3">
                                                    <label>Program/Event : <span><b>{{$req->event}}</b></span></label>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Currency : <span><b>{!!$req->currency!!}</b></span></label>
                                                </div>
                                                <div class="col-xl-3">
                                                    <label>Amount : <span><b>{{number_format($req->event)}}</b></span></label>
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