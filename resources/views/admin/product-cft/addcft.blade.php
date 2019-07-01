@extends('admin.master')

@section('title')
Add  Product CFT
@endsection

@section('mainContent')

<br>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="column">

                    <a href="{{ url('/product/cft/manage') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Manage Product CFT</a>

                </div>
            </div>
        </div>
        <br>
	<div class="card">
			     <div class="card-body">
				   <div class="card-title"> <i class="fa fa-plus"></i> Add  Product CFT</div>
				   <hr>				  
			   <!-- Add Product -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                   
                    <div class="row">
			      		<div class="col-sm-2" role="alert">
                  		</div>
             		</div>
                    <form action="{{route('product.cft.save')}}" method="POST">
                        @csrf
                            <div class="panel-body">
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label"> Grade Name : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-6">
                                                    
                                                      <select  class="form-control select2" name="grade_id" id="" required>
                                                          <option >Select One</option>
                                                          @foreach ($productGrade as $grade)
                                                          <option value="{{$grade->id}}">{{$grade->name.' '.'@'.$grade->price}}</option>
                                                          @endforeach
                                                        
                                                      
                                                      </select>
                                                  
                                               </div>
                                            </div>
                                        </div>

                                      
                                    </div>

                                    <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="length" class="col-sm-2 col-form-label"> Length : <i class="text-danger">*</i> </label>
                                                    <div class="col-sm-6">
                                                        <input type="number" class="form-control"  name="length" placeholder="Length.."  required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="width" class="col-sm-2 col-form-label"> Width : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control"  name="width" placeholder="Width.."  required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="height" class="col-sm-2 col-form-label"> Thickness : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control"  name="height" placeholder="Height.."  required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                  
            
                                   
                                  
                                    
            
                                    <br>
                                    <div class="form-group row">
                                          <label for="input-1" class="col-sm-4 col-form-label"></label>
                                          <div class="col-sm-4">
                                        <button type="submit" class="btn btn-primary shadow-primary px-5"></i> Add Product CFT</button>
                                      </div>
                                
                                
                                <br>
                    </form>
                            
                </div>
            </div>
        </div>

<!-- Add Product End -->
@endsection

