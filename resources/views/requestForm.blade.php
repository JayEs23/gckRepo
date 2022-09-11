@extends('layouts.app')

@section('content')    
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt-6">
        <div class="row justify-content-center">
            <form method="post" action="{{ route('requests.save') }}" autocomplete="off">
                @csrf
                <div class="row">
                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif
                </div>
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="mb-0"> REQUISITION FORM</h3>
                            </div>
                            <div class="col-6">
                                <select class='form-control' name='cat' oninput='setRequestForm(this.value)' name='districts' id='category' required>
                                    <option Selected>Choose a Category</option>                        
                                    <option value='1'><b>Cash Advance Requisition </b></option>
                                    <option value='2'><b>Purchase Requisition </b></option>
                                </select>
                            </div>
                            
                            <div class=''>
                            
                            <input type='hidden' class='form-control' id='title' name='title' >
                            <input type='hidden' class='form-control' id='officer' name='officer' value='{{auth()->user()->id}}'>
                          </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row icon-examples">
                            <div class="col-lg-2 col-md-4">
                                <label class="form-control-label" for="input-name">{{ __('Date') }}</label>
                                <input type="date" name="date" id="input-date" class="form-control form-control-alternative{{ $errors->has('date') ? ' is-invalid' : '' }}" placeholder="{{ __('Date') }}" value="" required >
                            </div>
                            <div class="col-lg-3 col-md-4">
                              <label class="form-control-label" for="input-name">{{ __('Name of Requester') }}</label>
                                <input type="text" name="name" id="input-date" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required >
                            </div>
                            <div class="col-lg-2 col-md-4">
                              <label class="form-control-label" for="input-name">{{ __('Phone') }}</label>
                                <input type="tel" name="phone" id="input-date" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone Number') }}" value="" required >
                            </div>
                            <div class="col-lg-3 col-md-6">
                              <label class="form-control-label" for="input-name">{{ __('Email Address') }}</label>
                                <input type="email" name="email" id="input-date" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required >
                            </div>
                            <div class="col-lg-2 col-md-6">
                              <label class="form-control-label" for="input-name">{{ __('Department/ Location') }}</label>
                                <input type="text" name="department" id="input-date" class="form-control form-control-alternative{{ $errors->has('department') ? ' is-invalid' : '' }}" placeholder="{{ __('Department') }}" value="" required >
                            </div>
                        </div>
                        <div class="row icon-examples mt-2">
                            <div class="col-lg-8 col-md-6">
                              <label class="form-control-label" for="input-name">{{ __('Purpose for the requested item(s)') }}</label>
                                <textarea name="purpose" class="form-control " rows="6" placeholder="Short note stating the purpose of the request, and any other relevant details to be considered during review of this application." required>
                                </textarea>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="col-lg-12">
                                  <label class="form-control-label" for="input-name">{{ __('Location/Region/Zone') }}</label>
                                    <input type="text" name="department" id="input-date" rows="6" class="form-control mt-2 form-control-alternative{{ $errors->has('department') ? ' is-invalid' : '' }}" placeholder="{{ __('Location/Region/Zone') }}" value="" required >
                                </div>
                                <div class="col-lg-12 mt-2">
                                  <label class="form-control-label" for="input-name">{{ __('Program/Event') }}</label>
                                    <input type="text" name="event" id="input-date" class="form-control mt-2 form-control-alternative{{ $errors->has('department') ? ' is-invalid' : '' }}" placeholder="{{ __('Program/Event') }}" value="" required >
                                </div>
                            </div>
                        </div>
                        <div class="row icon-examples mt-5 ml-2 mb-5">
                           
                            <div class="col-lg-2 col-md-6"> 
                                <h3 class="row">Currency</h3>
                            </div>
                            <div class="col-lg-10 col-md-12"> 
                                <div class="row">
                                    <div class="col-lg-4 col-md-6"> 
                                        <input type='radio' class='form-check-input mt-2' name='currency' id='optionsRadios1' value='&#163'><span class="ml-2">Pound Sterling (&#163)</span>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <input type='radio' class='form-check-input mt-2' name='currency' id='optionsRadios2' value='&#36'><span class="ml-2">US Dollars (&#36)</span>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <input type='radio' class='form-check-input mt-2' name='currency' id='optionsRadios3' value='&#8358' ><span class="ml-2">Naira(&#8358)</span>
                                    </div>             
                                </div>
                            </div>
                            
                        </div>
                        <div class='row' id='car' style='display:none'>
                            <div class='form-group col-12'>
                                <p class='card-description'>
                                  <b>Instructions</b>: <br>
                                  <i>Please complete this form as required and submit on time for needed approvals to avoid unnecessary delay. It is strongly advised that you submit your request at least two weeks prior to the time requested items would be used. All receipts (where applicable), supporting documentation and any unspent cash must be returned to the account department within 21 days of cash utilization. </i> 
                                </p>
                            </div>
                            <div class='form-group col-6'>
                                <div class='form-check'>
                                    <label class='form-check-label'>
                                      
                                    <i class='input-helper'></i></label>
                                </div>
                                <div class='form-group'>
                                    <label>Amount Requesting</label>
                                    <input type='number' name='amount' class='form-control'>
                                </div>
                            </div>
                                
                        </div>
                        <div class='row' id='pr' style='display:none'>
                            <div class='form-group col-12'>
                                <p class='card-description'>
                                  <b>Instructions</b>: <br>
                                  <i>Please complete this form as required and submit on time for needed approvals to avoid unnecessary delay. It is strongly advised that you submit your request at least two weeks prior to the time requested items would be used. All receipts (where applicable), supporting documentation and any unspent cash must be returned to the account department within 21 days of cash utilization. </i> 
                                </p>
                            </div>
                            <div class='form-group col-lg-12'>
                                <table class="table table-bordered" id="dynamicAddRemove">  
                                <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                                </tr>
                                <tr>  
                                <td><input type="text" name="moreFields[0][title]" placeholder="Enter title" class="form-control" /></td>  
                                <td><input type="text" name="moreFields[0][description]" placeholder="Enter item description" class="form-control" /></td>  
                                <td><input type="number" name="moreFields[0][qty]" placeholder="Enter Quantity" class="form-control" /></td>  
                                <td><input type="number" name="moreFields[0][price]" placeholder="Enter unit price" class="form-control" /></td>  
                                <td><input type="number" name="moreFields[0][amount]" placeholder="Enter Total Amount" class="form-control" /></td>  
                                <td><button type="button" name="add" id="add-btn" class="btn btn-success">Add More</button></td>  
                                </tr>  
                                </table> 
                            </div>
                                
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit"> Submit Request</button>
                        </div>
                        
                      </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function setRequestForm(form){
        var title = '';
        var form = form;
        if(form == 1){
          document.getElementById('car').style.display ='flex';
          document.getElementById('pr').style.display ='none';
          title = document.getElementById('title').value = 'Cash Advance Requisition';
          var title2 = document.getElementById('title').value = title;
        }else if(form == 2){
          document.getElementById('car').style.display ='none';
          document.getElementById('pr').style.display ='flex';
          title = document.getElementById('title').value = 'Purchase Requisition';
          var title2 = document.getElementById('title').value = title;
        }else{
          document.getElementById('car').style.display ='none';
          document.getElementById('pr').style.display ='none';
          title = document.getElementById('title').value = '';
          var title2 = document.getElementById('title').value = title;
        }
        
        
      }
    document.getElementsByTagName("textarea")[0].onkeydown = function(e){
        if (e.which == 13){
            return false
        }
    }

    var i = 0;
    $("#add-btn").click(function(){
    ++i;
    $("#dynamicAddRemove").append('<tr><td><input type="text" name="moreFields['+i+'][title]" placeholder="" class="form-control" /></td><td><input type="text" name="moreFields['+i+'][description]" placeholder="" class="form-control" /></td><td><input type="number" name="moreFields['+i+'][qty]" placeholder="" class="form-control" /></td><td><input type="number" name="moreFields['+i+'][price]" placeholder="" class="form-control" /></td><td><input type="number" name="moreFields['+i+'][amount]" placeholder="" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    });
    $(document).on('click', '.remove-tr', function(){  
    $(this).parents('tr').remove();
    });  
</script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush