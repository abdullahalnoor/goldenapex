@extends('employee.master')

@section('title')
    Money Collection
@endsection

@section('mainContent')

    <section class="content">
                <!-- Alert Message -->
        <div class="row">
            <div class="col-sm-12">
            @if(Session::has('message'))
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div class="text-center" style="font-size: 18px; padding: 9px; border: 2px solid #00B1E6;">
                     {{ Session::get('message') }}
                    </div>
                </div>
            @endif
            </div>
        </div>

    <div class="card mt-2">
                 <div class="card-body">
                   <div class="card-title"> <i class="fa fa-money"></i> Money Collection</div>
                   <hr>               
               <!-- Add Product -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                   
                    <div class="row">
                        <div class="col-sm-2" role="alert">
                        </div>
                    </div>
                    <form action="{{route('collection.save')}}" method="POST">
                        @csrf
                            <div class="panel-body">
                                <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-4 col-form-label">Collection Date : </label>
                                                <div class="col-sm-8">
                                                    <input type="date"  class="form-control"  name="date" placeholder="Product Code "  required />
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="category_id" class="col-sm-4 col-form-label">Customer : </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="category_id" name="customer_id" tabindex="3" required>
                                                    <option>--Select One--</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                                    @endforeach   
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                      
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="due" class="col-sm-4 col-form-label">Due Money : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-8">
                                                    <input class="form-control text-right"  name="due" type="number" required="" placeholder="0.00" tabindex="5" min="0">
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="address " class="col-sm-4 col-form-label">Descrpition</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" name="descrpition" id="descrpition " rows="3" placeholder="Descrpition" tabindex="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                          <label for="input-1" class="col-sm-3 col-form-label"></label>
                                          <div class="col-sm-3">
                                        <button type="submit" class="btn btn-primary shadow-primary px-5"></i> Save</button>
                                      </div>
                                <br>
                    </form>         
                </div>
            </div>
        </div>

<!-- Add Product End -->
@endsection
