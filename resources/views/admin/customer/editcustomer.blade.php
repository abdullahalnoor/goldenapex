@extends('admin.master')

@section('title')
	Update Customer Information
@endsection

@section('mainContent')

<br>
    <section class="content">
        <!-- Alert Message -->  
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<a href="{{url('/customer/manage')}}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Manage Customer </a>
{{-- 
                    <a href="#" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  Credit Customer </a>

                    <a href="#" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  Paid Customer </a> --}}
                </div>
            </div>
        </div>
        <br>
	<div class="card">
			     <div class="card-body">
				   <div class="card-title">Update Customer Information</div>
				   <hr>				   
				    {!! Form::open(['url' => '/customer/update','method'=>'POST']) !!}
<div class="form-group row">
    @csrf
                            <label for="customer_name" class="col-sm-3 col-form-label">Customer Name <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="customer_name" id="customer_name" type="text" value="{{$customer_info->customer_name}}"  required="" tabindex="1">
                                <input  name ="id"  type="hidden" value="{{$customer_info->id}}" >
                            </div>
                        </div>

                       	<div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Customer Email </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="email" id="email" type="email" value="{{$customer_info->customer_email}}"  tabindex="2" > 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label">Customer Mobile <i class="text-danger">*</i> </label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="mobile" id="mobile" type="text" value="{{$customer_info->customer_mobile}}"  min="0" tabindex="3" required="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address " class="col-sm-3 col-form-label">Customer Address <i class="text-danger">*</i> </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="address" id="address " rows="3"  tabindex="4" required="">{{$customer_info->customer_address}}</textarea>
                            </div>
                        </div>
                    <!--  <div class="form-group row">
					  <label for="input-4" class="col-sm-3 col-form-label">Status :</label>
					  	<div class="col-sm-6">
						<select name="status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Unactive</option>
						</select>
					  </div>
					</div>-->
                        {{-- <div class="form-group row">
                            <label for="previous_balance" class="col-sm-3 col-form-label">Previous Credit Balance </label>
                            <div class="col-sm-6">
                                <input class="form-control" name="previous_balance" id="previous_balance" type="text" value="{{$customer_info->customer_address}}" tabindex="5" >
                            </div>
                        </div>  --}}
					<div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="reset" class="btn btn-danger" value="Reset" tabindex="6"/>
                                <input type="submit" class="btn btn-info" value="Update" />
                            </div>
                        </div>
					{!! Form::close() !!}
				 </div>
			   </div>

@endsection