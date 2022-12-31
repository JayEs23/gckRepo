@extends('layouts.app')

@section('content')    
    <style>
        .serial-number {
      display: inline-block;
      width: 2em;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-right: 4px;
    }
    </style>
    
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
            <form method="post" id="request" action="{{ route('requests.save') }}" autocomplete="off"  enctype="multipart/form-data">
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
                                <select class='form-control' id="cat" name='cat' oninput='setRequestForm(this.value)' name='districts' id='category' required>
                                    <option Selected disabled>Choose a Category</option>                        
                                    <option value='1'><b>Cash Advance Requisition </b></option>
                                    <option value='2'><b>Purchase Requisition </b></option>
                                </select>
                            </div>
                            
                            <div class=''>
                            
                            <input type='hidden' id="title" class='form-control' id='title' name='title' >
                            <input type='hidden' id="officer" class='form-control' id='officer' name='officer' value='{{auth()->user()->id}}'>
                          </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row icon-examples">
                            <div class="col-lg-2 col-md-4" style='display:none !important'>
                                <label class="form-control-label" for="input-name">{{ __('Date') }}</label>
                                <input type="date" name="date" value="<?php echo  date('Y-m-d'); ?>" id="input-date" class="form-control form-control-alternative{{ $errors->has('date') ? ' is-invalid' : '' }}" placeholder="{{ __('Date') }}" value="" required >
                            </div>
                            <div class="col-lg-3 col-md-4">
                              <label class="form-control-label" for="input-name">{{ __('Name of Requester') }}</label>
                                <input type="text" name="name" id="requester" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required  disabled>
                            </div>
                            <div class="col-lg-2 col-md-4">
                              <label class="form-control-label" for="input-name">{{ __('Phone') }}</label>
                                <input type="tel" name="phone" id="phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone Number') }}" value="" required >
                            </div>
                            <div class="col-lg-3 col-md-6">
                              <label class="form-control-label" for="input-name">{{ __('Email Address') }}</label>
                                <input type="email" name="email" id="email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required disabled>
                            </div>
                            <div class="col-lg-4 col-md-6">
                              <label class="form-control-label" title="Choose a Department or Location" for="input-name">{{ __('Dept./ Location') }}</label>
                                <select class='form-control' title="Choose a Department or Location" oninput='setRequestForm(this.value)' name='department' id='location' required>
                                    <option Selected disabled>Choose a Department/Location</option>                        
                                </select>
                            </div>
                        </div>
                        <div class="row icon-examples mt-2">
                            <div class="col-lg-8 col-md-6">
                              <label class="form-control-label" for="input-name">{{ __('Purpose for the requested item(s)') }}</label>
                                <textarea name="purpose" class="form-control " id="purpose" rows="6" placeholder="Short note stating the purpose of the request, and any other relevant details to be considered during review of this application." required></textarea>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="col-lg-12">
                                  <label class="form-control-label" for="input-name">{{ __('Location/Region/Zone') }}</label>
                                    <select class='form-control' oninput='setRequestForm(this.value)' name='zone' id='zone' required>
                                        <option Selected disabled>Choose a Location/Region/Zone</option>                        
                                    </select>
                                </div>
                                <div class="col-lg-12 mt-2">
                                  <label class="form-control-label" for="input-name">{{ __('Program/Event') }}</label>
                                    <input type="text" name="event" id="event" class="form-control mt-2 form-control-alternative{{ $errors->has('department') ? ' is-invalid' : '' }}" placeholder="{{ __('Program/Event') }}" value="" required >
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
                                        <input type='radio' class='form-check-input mt-2' name='currency' id='currency1' value='&#163'><span class="ml-2">Pound Sterling (&#163)</span>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <input type='radio' class='form-check-input mt-2' name='currency' id='currency2' value='&#36'><span class="ml-2">US Dollars (&#36)</span>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <input type='radio' class='form-check-input mt-2' name='currency' id='currency3' value='&#8358' ><span class="ml-2">Naira(&#8358)</span>
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
                            
                                
                        </div>
                        <div class='row' id='pr' style='display:none'>
                            <div class='form-group col-10'>
                                <p class='card-description'>
                                  <b>Instructions</b>: <br>
                                  <i>Please complete this form as required and submit on time for needed approvals to avoid unnecessary delay. It is strongly advised that you submit your request at least two weeks prior to the time requested items would be used. All receipts (where applicable), supporting documentation and any unspent cash must be returned to the account department within 21 days of cash utilization. </i> 
                                </p>
                                <button type="button" name="add" id="add-btn"  class="btn btn-secondary mb-2" ><i class="fa fa-plus"></i> Add Item</button>
                            </div>
                            <div class='row form-inline ml-5' id="dynamicAddRemove">
                              <div class="col-12">
                                 <b class="serial-number">1</b>
                                <input type="text" name="moreFields[0][title]" id="title_0" class="form-control mb-2" id="item" placeholder="Item name" size="10">
                              
                                <input type="text" name="moreFields[0][description]" id="desc_0" class="form-control mb-2" id="description" placeholder="Item description" size="20">
                              
                                <input type="number" name="moreFields[0][qty]" id ="quantity_0" oninput="getTotal(0)" class="form-control mb-2" style="width: 10em;" id="quantity" placeholder="Quantity" size="10">
                              
                                <input type="number" name="moreFields[0][price]" id ="price_0" oninput="getTotal(0)" class="form-control mb-2" style="width: 10em;" id="price" placeholder="Price" size="10">
                                <input type="number" name="moreFields[0][amount]" id="total_0"  class="form-control mb-2" id="total" placeholder="Total" size="10">
                              
                                
                                <hr>
                              </div>
                            
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class='form-group col-6'>
                                <div class='form-check'>
                                    <label class='form-check-label'>
                                      
                                    <i class='input-helper'></i></label>
                                </div>
                                <div class='form-group'>
                                    <label>Amount Requesting</label>
                                    <input type='number' id="amount" name='amount' class='form-control'>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="document">Upload Documents</label>
                                    <input type="file" class="form-control-file" id="documents" name="documents[]" multiple>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-info" name="save" id="save" type="button"> Save </button>
                            <button class="btn btn-success " type="submit"> Submit Request</button>
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
    
    
        let items = 1;
        let amounts = [];
        let totalAmount = 0;
        let purchase_items = [];
        
        function getItems(){
            alert('Yeehah!!!')
            for (let i = 0; i < items; i++) {
                let title = document.getElementById('title_'+i).value;
                let desc = document.getElementById('desc_'+i).value;
                let quan = document.getElementById('quantity_'+i).value;
                let prc = document.getElementById('price_'+i).value;
                let tot = document.getElementById('total_'+i).value;
                let item = {
                    'title': title,
                    'description': desc,
                    'qty': quan,
                    'price': prc,
                    'amount': amount,
                } 
              purchase_items[i] = item[i];
              console.log(JSON.stringify(purchase_items));
            }
        }

        function getTotal(n){
            let p = document.getElementById('price_'+n).value;
            let q = document.getElementById('quantity_'+n).value;
            let price = parseInt(p);
            let quantity= parseInt(q);
            if(q = ''){
                alert('Please Quantity');
                document.getElementById('total_'+n).disabled =true;
                document.getElementById('quantity_'+n).style.borderColor ='red';
                document.getElementById('total_'+n).style.borderColor ='red';
            }
            else if(p = ''){
                alert('Please Quantity');
                document.getElementById('total_'+n).disabled =true;
                document.getElementById('price_'+n).style.borderColor ='red';
                document.getElementById('total_'+n).style.borderColor ='red';
            }else{
                var t = price*quantity;
                document.getElementById('total_'+n).value = t;
                amounts[n] = t;
                getGrandTotal();
                document.getElementById('total_'+n).style.borderColor ='inherit';
            }
            
            
        }
        function getGrandTotal(){
            let grandTotal = amounts.reduce(function (accumVariable, curValue) {
                return accumVariable + curValue},0);
                var totAmount = document.getElementById('amount').value = grandTotal ;
        }
        
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
              var totAmount = document.getElementById('amount').disabled = true;
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
            ++items;
            ++i;
            $("#dynamicAddRemove").append('<div class="col-12"><b class="serial-number">' + (i + 1) + '</b><input type="text" name="moreFields['+i+'][title]" id="title_'+i+'" class="form-control mb-2" placeholder="Item name" size="10"><input type="text" name="moreFields['+i+'][description]" id="desc_'+i+'" class="form-control mb-2" placeholder="Item description" size="20"><input type="number" name="moreFields['+i+'][qty]" id ="quantity_'+i+'" oninput="getTotal('+i+')" class="form-control mb-2" style="width: 10em;" placeholder="Quantity" size="10"><input type="number" name="moreFields['+i+'][price]" id ="price_'+i+'" oninput="getTotal('+i+')" class="form-control mb-2" style="width: 10em;" placeholder="Price" size="10"><input type="number" name="moreFields['+i+'][amount]" id="total_'+i+'"  class="form-control mb-2" placeholder="Total" size="10"> <button type="button" class="btn btn-danger remove-tr"><i class="fa fa-trash"></i></button><hr></div>');
        });
        
        $(document).on('click', '.remove-tr', function(){  
            $(this).parents('.col-12').remove();
            --i;
        });  
        

</script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush