@extends('layouts.app')

@section('content')
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
            $declined[] = $request;
        }
        else if ($request->status == 3) {
            $denied[] = $request;
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
    
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-xl-3 mt-2">
                    <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('Users') }}</a>
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
                
            </div>
        </div>
    </div>
    
    <div class="container-fluid mt--7" >
        <div class="row">
            @if (Session::has('success'))
            <div class="alert alert-success text-center">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('success') }}</p>
            </div>
            @endif
        </div>
        <div class="row mt-5" style="min-height:400px !important">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Users</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('users.create') }}" class="btn btn-sm btn-dark">New User</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($users) > 0)
                                @foreach($users as $user)
                                <tr>
                                    <th scope="row">
                                        {{$user->name}}
                                    </th>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                    <td>
                                        <span> <?php echo status($user->is_admin) ?></span>
                                    </td>
                                    
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal{{$req->id}}"><i class="fas fa-eye"></i></button>
                                        <a class="btn btn-dark btn-sm" href="{{ route('requests.show',$req->id) }}"><i class="fas fa-edit"></i></a>
                                        @if(auth()->user()->is_admin == 2)
                                        <a class="btn btn-success btn-sm" href="{{ route('requests.resolve',$req->id) }}"><i class="fas fa-check"></i></a>
                                         <a class="btn btn-danger btn-sm" href="{{ route('requests.decline',$req->id) }}"><i class="fas fa-check"></i></a>
                                        @endif
                                        @if(auth()->user()->is_admin == 1)
                                       
                                        
                                         <a class="btn btn-success btn-sm" href="{{ route('requests.approve',$req->id) }}"><i class="fas fa-check"></i></a>
                                         <a class="btn btn-danger btn-sm" href="{{ route('requests.deny',$req->id) }}"><i class="fas fa-times-circle"></i></a>
                                        @endif
                                        
                                         
                                    </td>
                                </tr>
                                <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">{{$user->name}}</h3>
                                            
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <label>Full Name : <span><b>{{$user->name}}</b></span></label>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label>Email : <span><b>{{$user->email}}</b></label>
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