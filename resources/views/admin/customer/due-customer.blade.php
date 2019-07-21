@extends('admin.master')

@section('mainContent')

@section('title')
	Manage customer
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

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <a href="{{ url('/customer/add') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> Add customer </a>
                    {{-- <a href="{{ url('/customer/credit') }}" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  Credit Customer </a>

                    <a href="{{ url('/customer/paid') }}" class="btn btn-warning m-b-5 m-r-2"><i class="ti-align-justify"> </i>  Paid Customer </a> --}}

                </div>
            </div>
        </div>
<br>


      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> All customers </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="text-center">
                    	<th>Customer ID</th>
                        <th>Customer name</th>
                        <th>address</th>
                        <th>mobile</th>
                   
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	<?php $i=0; ?>

                    @foreach($customer_info as $customer)
                    @if(!$customer->paidCustomer($customer->id))
                    <tr class="text-center">
                        <td>{{ ++$i }}</td>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ $customer->customer_address }}</td>
                        <td>{{ $customer->customer_mobile }}</td>
                    
                        <td>{{$customer->customerCreditAmount($customer->id) }}</td>
                        <td><a class="btn btn-info btn-sm" href="{{ url('/customer/edit/'.$customer->id) }}"><i style="font-size: 16px;" class="fa fa-edit" data-toggle="tooltip" title="Update"></i></a>  
                             {{-- <a class="btn btn-danger btn-sm" href="{{ url('/customer/delete/'.$customer->id) }}"><i style="font-size: 16px;" class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></a></td> --}}
                    </tr>
                    @endif
                    @endforeach

                </tbody>
            </table>
           {{$customer_info->links()}}
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

@endsection
