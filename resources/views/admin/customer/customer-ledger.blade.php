@extends('admin.master')

@section('mainContent')

@section('title')
Generate Customer Ledger
@endsection

<br>
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

     
        <div class="card">
            <div class="card-body">
              <div class="card-title">Generate Customer Ledger</div>
              <hr>				   
               <form id="generateLedeger" action="{{route('customer.ledger-detail')}}" method="POST"> 
                   @csrf
                <div class="form-group row">
                       <label for="customer_id" class="col-sm-3 col-form-label">Customer Name <i class="text-danger">*</i></label>
                       <div class="col-sm-6">
                           <select  class="form-control" name="customer_id" id="">
                               <option >Select One</option>
                               @foreach ($customer_info as $customer)
                                   <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>

                   <br>

             
               <div class="form-group row">
                       <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                       <div class="col-sm-6">
                          
                           <input type="submit"  class="btn btn-info" value="View Customer Ledger " >
                       </div>
                   </div>
                </form>
            </div>
          </div>


     {!!$view!!}

@endsection



