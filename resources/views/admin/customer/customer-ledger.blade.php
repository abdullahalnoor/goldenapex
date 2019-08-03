@extends('admin.master')

@section('mainContent')

@section('title')
 Customer Ledger
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
              <div class="card-title"> Customer Ledger</div>
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


         
<div class="row mt-2" >
        @if(!empty($current_customer_info))
    <div class="col-sm-12 text-center">
            <button  class="btn btn-primary " onclick="printDiv('printableArea')"><span class="fa fa-print"></span> Print Ledger</button>

    </div>
    @endif
    <div class="col-sm-12">

      <div class="card">
        <div class="card-header"><i class="fa fa-table"></i>  Customer Ledger </div>
        
        <div class="card-body" id="printableArea">
          <div class="table-responsive">
                @if(!empty($current_customer_info))  <h5 class="ml-5 mb-2">{{$current_customer_info->customer_name.'\'s Ledger Information'}}</h5> @endif
          <table  class="table table-bordered table-striped table-hover">
            <thead>
                        <tr class="text-center">
                            <th>Date</th>
                            <th>Activity</th>
                            <th>Invoice</th>
                            <th>Payment</th>
                            <th>Balance</th>
                           
                        </tr>
                    </thead>
                   
                    <tbody id="tableBody ">
                     @if(!empty($customerPayment))
                        @php($balance = 0)
                      
                      
                        @foreach ($customerPayment as $customerPaid)
                            <tr>
                                <td>{{$customerPaid->date}}</td>
                                <td>
                                    @if ($customerPaid->type == 0)
                                        Invoice
                                        @php($data = $customerPaid->invoiceInfo($customerPaid->invoice_id))
                                        {{'('.$data['product_name'].')'}} -
                                        {{'('.$data['sell_invoice_no'].')'}}
                                        
                                    @elseif($customerPaid->type == 1)
                                        Paid
                                    @elseif($customerPaid->type == 2)
                                        Return
                                        {{'('.$data['product_name'].')'}} -
                                        {{'('.$data['sell_invoice_no'].')'}}
                                    @endif
                                    
                                </td>
                                <td>
                                        @if ($customerPaid->type == 0)
                                            @php($balance += $customerPaid->payment_total)
                                           
                                                {{$customerPaid->payment_total}}
                                        @endif
                                    </td>
                                <td>
                                     @if ($customerPaid->type == 1)
                                        @php($balance -= $customerPaid->payment_total)
                                      
                                            {{$customerPaid->payment_total}}
                                    @elseif($customerPaid->type == 2)
                                        @php($balance -= $customerPaid->payment_total)
                                       
                                             {{$customerPaid->payment_total}}   
                                    @endif
                             </td>
                                <td>{{$balance}}</td>
                            </tr>
                            
                        @endforeach
                        <tr>
                                <td colspan="2" style="text-align:right">
                                        <b>Transaction Total</b>
                                </td>
                                <td >
                                        {{$totalInvoiceAmount}}
                                    </td>
                                <td >
                                    {{$totalPaidAmount}}
                                </td>
                                <td></td>
                            </tr>
    
                    </tbody>
                    @endif
                </table>
                
                </div>
                </div>
              </div>
            </div>
          </div><!-- End Row-->

         

@endsection



@push('script')

    
   


 <!-- Printable area start -->
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        document.body.style.marginTop="100px";
        document.body.style.padding="10px";
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
    

@endpush

