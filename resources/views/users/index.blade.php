@extends('layouts.app')

@section('content')
<?php
    $general = [];
    $accounts = [];
    $admins = [];

    foreach ($users as $user) {
        if ($user->status == 1) {
            $admins[] = $user;
        }
        else if ($user->status == 2) {
            $accounts[] = $user;
        }
        else {
            $general[] = $user;
        }

    }

    function status($value)
    {
        $stat = '';
        switch ($value) {
          case "1":
            $stat = '<span class="btn btn-sm btn-info">Admin</span>';
            break;
          case "2":
            $stat = '<span class="btn btn-sm btn-danger">Accountant</span>';
            break;
          default:
            $stat = '<span class="btn btn-sm btn-warning">General User</span>';
        }
        return $stat;
    }


?>
    
    <div class="header bg-gradient-primary pb-8 pt-md-8">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-xl-3">
                    <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('Users') }}</a>
                </div>
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
            @if (Session::has('error'))
            <div class="alert alert-warning text-center">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('error') }}</p>
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
                                <button class="btn btn-sm btn-dark" data-toggle="modal" data-target="#exampleModal">New User</a>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel">{{$user->name}}</h3>
                                            
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <form role="form" method="POST" action="{{ route('users.save') }}">
                                                @csrf

                                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                                    <div class="input-group input-group-alternative mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                                        </div>
                                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" type="text" name="name" value="{{ old('name') }}" required autofocus>
                                                    </div>
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                    <div class="input-group input-group-alternative mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                                        </div>
                                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" required>
                                                    </div>
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                                    <div class="input-group input-group-alternative mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                                        </div>
                                                        <select name="is_admin" required class="form-control">
                                                            <option>Choose Category</option>
                                                            <option value="0">General User</option>
                                                            <option value="1">Admin</option>
                                                            <option value="2">Accountant</option>
                                                        </select> 
                                                    </div>
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                        </div>
                                                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" type="password" name="password" required>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                        </div>
                                                        <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password" name="password_confirmation" required>
                                                    </div>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-success" >Create User</button>
                                            </form>
                                          </div>
                                          <div class="modal-footer">
                                            
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
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
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal{{$user->id}}" data-toggle="tooltip" data-placement="left" title="View User Details"><i class="fas fa-eye"></i></button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete" data-toggle="tooltip" data-placement="left" title="Delete {{$user->name}}"><i class="fas fa-trash"></i></button>
                                        @if(auth()->user()->is_admin == 1)
                                            @if($user->is_admin == 2)
                                                <a class="btn btn-success btn-sm" href="{{ route('users.makeAdmin',$user->id) }}" data-toggle="tooltip" data-placement="left" title="Make Admin"><i class="fas fa-user-cog"></i></a>
                                                <a class="btn btn-secondary btn-sm" href="{{ route('users.makeUser',$user->id) }}" data-toggle="tooltip" data-placement="left" title="Make User"><i class="fas fa-user"></i></a>
                                            @elseif($user->is_admin == 1)
                                            <a class="btn btn-warning btn-sm" href="{{ route('users.makeAccount',$user->id) }}" data-toggle="tooltip" data-placement="left" title="Make Accountant"><i class="fas fa-user-secret"></i></a>
                                            <a class="btn btn-secondary btn-sm" href="{{ route('users.makeUser',$user->id) }}"  data-toggle="tooltip" data-placement="left" title="Make Accountant"><i class="fas fa-user"></i></a>
                                            @else
                                            <a class="btn btn-success btn-sm" href="{{ route('users.makeAdmin',$user->id) }}" data-toggle="tooltip" data-placement="left" title="Make Admin"><i class="fas fa-user-cog"></i></a>
                                            <a class="btn btn-warning btn-sm" href="{{ route('users.makeAccount',$user->id) }}" data-toggle="tooltip" data-placement="left" title="Make Accountant"><i class="fas fa-user-secret"></i></a>
                                            @endif
                                        @endif
                                        
                                        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$user->name}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <h3>Are you sure you want to delete this user?</h3>
                                              </div>
                                              <div class="modal-footer">
                                               
                                                <a class="btn btn-danger" href="{{ route('users.destroy',$user->id) }}">Yes</a> 
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
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