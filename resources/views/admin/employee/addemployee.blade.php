@extends('admin.master')

@section('title')
	Add Employee Information
@endsection

@section('mainContent')
    <section class="content">
        <!-- Alert Message -->  
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                	<a href="#" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Manage Employee </a>

                    <!-- <a href="#" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  Credit Employee </a>
                    
                    <a href="#" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  Paid Customer </a> -->
                </div>
            </div>
        </div>
	<div class="card mt-2">
			     <div class="card-body">
				   <div class="card-title">Add Employee Information</div>
				   <hr>				   
				    {!! Form::open(['url' => '/employee/save','method'=>'POST']) !!}
						<div class="form-group row">
                            <label for="Employee_name" class="col-sm-3 col-form-label">Employee Name <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="Employee_name" id="Employee_name" type="text" placeholder="Employee Name"  required="" tabindex="1">
                            </div>
                        </div>

                        <div class="form-group row">
				  			<label for="email" class="col-sm-3 col-form-label">{{ __('Employee Email') }} <i class="text-danger">*</i></label>
				  		<div class="col-sm-6">
				  			<input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Employee Email" name="email" value="{{ old('email') }}" required tabindex="2">
						</div>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
			  			</div>

                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="phone" id="mobile" type="text" placeholder="Employee Phone" min="0" tabindex="3">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address " class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="address" id="address " rows="3" placeholder="Employee Address" tabindex="4"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="previous_balance" class="col-sm-3 col-form-label">Previous Credit Balance</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="previous_balance" id="previous_balance" type="number" placeholder="Previous Credit Balance" tabindex="5">
                            </div>
                        </div> 
                    <div class="form-group row">
                        <label for="designation" class="col-sm-3 col-form-label">Designation <i class="text-danger">*</i></label>
                         	<div class="col-sm-6">
                                <input class="form-control" name="designation" id="designation" type="text" placeholder="Designation" tabindex="6" required>
                            </div>
                    </div>

                    <div class="form-group row">
				  		<label for="password" class="col-sm-3 col-form-label">{{ __('Password') }} <i class="text-danger">*</i></label>
				  		<div class="col-sm-6">
				  			<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required tabindex="7">
						</div>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
			   		</div>

			  		<div class="form-group row">
				  		<label for="password-confirm" class="col-sm-3 col-form-label">{{ __('Confirm Password') }} <i class="text-danger">*</i></label>
				  		<div class="col-sm-6">
				  			<input id="password-confirm" type="password" class="form-control" placeholder="Retry Password" name="password_confirmation" required tabindex="8">
						</div>
			   		</div>

					<div class="form-group row">
                        <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-6">
                            <input type="reset" class="btn btn-danger" value="Reset" tabindex="6"/>
                            <input type="submit" id="add-deposit" class="btn btn-info" name="add-deposit" value="Save" tabindex="9" >
                        </div>
                    </div>
					{!! Form::close() !!}
				 </div>
			   </div>

@endsection