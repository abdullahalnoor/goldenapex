@extends('admin.master')

@section('mainContent')

@section('title')
Manage Payment
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
                    <a href="{{ url('/customer/add-payment') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> Add Payment </a>
                   
                </div>
            </div>
        </div>
<br>


      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Manage Payment </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="text-center">
                    	<th> ID</th>
                        <th>Customer name</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                	<?php $i=0; ?>

                    @foreach($customerPayment as $payment)
                    
                    <tr class="text-center">
                        <td>{{ ++$i }}</td>
                        <td>
                           @foreach ($customer_info as $customer)
                               @if ($customer->id == $payment->customer_id)
                               {{ $customer->customer_name }}
                               @endif
                           @endforeach
                            
                        </td>
                        <td>{{ $payment->type == 1 ? 'Paid' : 'Return' }}</td>
                        <td>{{ $payment->payment_total }}</td>
                    </tr>
                    
                    @endforeach

                </tbody>
            </table>
            {{$customerPayment->links()}}
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

@endsection
