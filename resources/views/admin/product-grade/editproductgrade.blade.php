@extends('admin.master')

@section('title')
	Update Product
@endsection

@section('mainContent')

<br>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="column">

                    <a href="{{ url('/product/manage') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Manage Product </a>

                </div>
            </div>
        </div>
        <br>
	<div class="card">
			     <div class="card-body">
				   <div class="card-title"> <i class="fa fa-edit"></i> Update Product Information</div>
				   <hr>				  
			   <!-- Add Product -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                   
                    <div class="row">
			      		<div class="col-sm-2" role="alert">
                  		</div>
             		</div>
                     <form action="{{route('product.grade.update')}}" method="POST">
                        @csrf
                            <div class="panel-body">
                                    <div class="row">
                                        
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-2 col-form-label"> Grade Name : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-6">
                                                    <input type="text"  class="form-control"name="name" value="{{$productGrade->name}}" required=""  />
                                                </div>
                                            </div>
                                        </div>

                                      
                                    </div>

                                    <div class="row">
                        
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="price" class="col-sm-2 col-form-label">Grade Price: <i class="text-danger">*</i> </label>
                                                <div class="col-sm-6">
                                                    <input type="number" class="form-control"  name="price" value="{{$productGrade->price}}"  required />
                                                    <input type="hidden"  name="id" value="{{$productGrade->id}}"   />
                                                </div>
                                            </div>
                                        </div>
            
                                    </div>
            
                                   
                                  
                                    
            
                                    <br>
                                    <div class="form-group row">
                                          <label for="input-1" class="col-sm-4 col-form-label"></label>
                                          <div class="col-sm-4">
                                        <button type="submit" class="btn btn-primary shadow-primary px-5"></i> Update Product Grade</button>
                                      </div>
                                
                                
                                <br>
                    </form>
                            
                </div>
            </div>
        </div>

<!-- Add Product End -->
@endsection
