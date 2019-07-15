<div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Customer Ledger Detail </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="text-center">
                    	<th>Date</th>
                        <th>Activity</th>
                        <th>Invoice</th>
                        <th>Payment</th>
                        <th>Balance</th>
                       
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @php($balance = 0)
                  
                  
                	@foreach ($customerPayment as $customerPaid)
                        <tr>
                            <td>{{$customerPaid->date}}</td>
                            <td>
                                @if ($customerPaid->type == 0)
                                    invoice
                                    @php($data = $customerPaid->invoiceInfo($customerPaid->invoice_id))
                                    {{'['.$data['product_name'].']'}} -
                                    {{'['.$data['sell_invoice_no'].']'}}
                                    
                                @elseif($customerPaid->type == 1)
                                    paid
                                @elseif($customerPaid->type == 2)
                                    return
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
                            <td>
                                {{$totalPaidAmount}}
                            </td>
                        </tr>

                </tbody>
            </table>
           
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->