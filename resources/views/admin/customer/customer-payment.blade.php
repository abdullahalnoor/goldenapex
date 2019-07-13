@extends('admin.master')

@section('title')
	Add Customer Information
@endsection

@section('mainContent')

<br>
    <section class="content">
        <!-- Alert Message -->  
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<a href="{{url('/customer/manage')}}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Customer Payment</a>
                </div>
            </div>
        </div>
        <br>
	<div class="card">
			     <div class="card-body">
				   <div class="card-title"> Customer Information</div>
				   <hr>				   
                    {!! Form::open(['route' => 'customer.add-payment','method'=>'POST']) !!}
                    @csrf
                        <div class="form-group row">
                            <div class="col-sm-6">
                               <div class="row">
                                <label for="date" class="col-sm-4 col-form-label">Date  <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name ="date" id="date" type="date"   required="" >
                               </div>
                            </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                 <label for="customer_id" class="col-sm-4 col-form-label">Customer Name <i class="text-danger">*</i></label>
                                 <div class="col-sm-8">
                                     <select  class="form-control" name ="customer_id" id="customer_id">
                                         @foreach ($customer_info as $customer)
                                             <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                         @endforeach
                                     </select>
                                </div>
                             </div>
                             </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                               <div class="row">
                                <label for="customer_mobile" class="col-sm-4 col-form-label">Mobile  </label>
                                <div class="col-sm-8">
                                    <input class="form-control" readonly name ="customer_mobile" id="customer_mobile" type="text"   >
                               </div>
                            </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                 <label for="customer_address" class="col-sm-4 col-form-label">Customer Address </label>
                                 <div class="col-sm-8">
                                    <input class="form-control"readonly name ="customer_address" id="customer_address" type="text"   >
                                </div>
                             </div>
                             </div>
                        </div>

                        <hr>
                       <br>

                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="column">
                                    <h4>Receive Amount</h4>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>

                        <div class="form-group row ">
                            <div class="col-sm-12">
                               <div class="row text-center">
                                <label for="balance" class="col-sm-3 col-form-label">Balance </label>
                                <div class="col-sm-5">
                                    <input class="form-control" readonly name ="balance" id="balance" type="text"   >
                               </div>
                            </div>
                            </div>
                        
                        </div>

                        <div class="form-group row ">
                            <div class="col-sm-12">
                               <div class="row text-center">
                                <label for="receive_amount" class="col-sm-3 col-form-label">Receive Amount  <i class="text-danger">*</i></label>
                                <div class="col-sm-5">
                                    <input class="form-control"  name ="receive_amount" id="receive_amount" type="text"   >
                               </div>
                            </div>
                            </div>
                        
                        </div>


                        <div class="form-group row ">
                            <div class="col-sm-12">
                               <div class="row text-center">
                                <label for="due" class="col-sm-3 col-form-label">Due  </label>
                                <div class="col-sm-5">
                                    <input class="form-control" readonly name ="due" id="due" type="text"   >
                               </div>
                            </div>
                            </div>
                        
                        </div>



					<div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="reset" class="btn btn-danger" value="Reset" tabindex="6"/>
                                <input type="submit" id="add-deposit" class="btn btn-info" name="add-deposit" value="Save" tabindex="7"/>
                            </div>
                        </div>
					{!! Form::close() !!}
				 </div>
			   </div>

@endsection


@push('script')
    <script>
    
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $('select').select2();
            });

            var balance = 0;

            $(document).on("change keyup keypress keydown","#customer_id",function(e){
                const customerId = e.target.value;
             

                var route = "{{url('/customer/detail/')}}"+'/'+customerId;

                $.get(route,function(data){

                    console.log(data.customer.customer_mobile);
                    balance = parseFloat(data.balance.toFixed(2));
                    $("#customer_mobile").val(data.customer.customer_mobile);
                    $("#customer_address").val(data.customer.customer_address);
                    $("#balance").val(balance);
                });

            })



        })//end of ready

    </script>
@endpush