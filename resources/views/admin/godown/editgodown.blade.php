@extends('admin.master')

@section('title')
	Update Godown
@endsection

@section('mainContent')

<br>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="column">

                    <a href="{{ route('godown.manage') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Manage Godown </a>

                </div>
            </div>
        </div>
        <br>
	<div class="card">
			     <div class="card-body">
				   <div class="card-title"> <i class="fa fa-edit"></i> Update Godown</div>
				   <hr>				  
			   <!-- Add Product -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                   
                    <div class="row">
			      		<div class="col-sm-2" role="alert">
                  		</div>
             		</div>
                    <form action="{{route('godown.update')}}" method="POST">
                        @csrf
                            <div class="panel-body">
                                    <div class="row">
                                    
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label">Godown Name : <i class="text-danger">*</i></label>
                                                <div class="col-sm-6">
                                                    <input type="text"  class="form-control"name="name" value="{{$godown->name}}" />
                                                    <input type="hidden"  name="id" value="{{$godown->id}}" />
                                                </div>
                                            </div>
                                        </div>
            
                                    </div>
            
                                    <div class="row">
                                      
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="mobile" class="col-sm-2 col-form-label">Mobile : <i class="text-danger">*</i></label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control"  name="mobile" value="{{$godown->mobile}}"  required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>                        
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="address" class="col-sm-2 col-form-label">Address  : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control " cols="30"  rows="5" name="address" type="text" >{{$godown->name}}</textarea>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                       <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="unit" class="col-sm-2 col-form-label">Status : </label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" id="unit" name="status" >
                                                                                     
                                                        <option value="1" {{$godown->status == 1 ? 'selected' : ' '}}>Active</option>
                                                        <option value="0" {{$godown->status == 0 ? 'selected' : ' '}}>Deactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                       </div>
                                    </div>
                                  
                                    
            
                                    <br>
                                    <div class="form-group row">
                                          <label for="input-1" class="col-sm-4 col-form-label"></label>
                                          <div class="col-sm-4">
                                        <button type="submit" class="btn btn-primary shadow-primary px-5"></i> Update Godown</button>
                                      </div>
                                
                                
                                <br>
                    </form>
                            
                </div>
            </div>
        </div>

<!-- Add Product End -->
@endsection
