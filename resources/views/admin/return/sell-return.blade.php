

            <form action="{{route('submit.return.sell.product')}}" class="form-vertical" id="insert_purchase" name="insert_purchase" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                        {{csrf_field()}}
            <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="customer_id" class="col-sm-4 col-form-label">customer : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-8">
                                                    <select disabled class="form-control" id="customer_id" name="customer_id" tabindex="3">
                                                       
                                                        @foreach ($customer_info as $customer)
                                                        <option  value="{{$customer->id}}" {{$customer->id == $invoice->customer_id ? 'selected' : ''}}>{{$customer->customer_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-4 col-form-label">Sell Date : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-8">
                                                    <input disabled type="date"  class="form-control"name="date" value="{{$invoice->date}}"   />
                                                </div>
                                            </div>
                                        </div>
            
                                    </div>
            
                                    <div class="row">

                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="payment_type" class="col-sm-4 col-form-label">Payment Type : </label>
                                                        <div class="col-sm-8">
                                                            <select disabled class="form-control" id="payment_type" name="payment_type" >
                                                                                                       
                                                                <option value="Due" {{$invoice->payment_type == 'Due' ? 'selected' : ''}}>Due </option>
                                                                <option value="Paid" {{$invoice->payment_type == 'Paid' ? 'selected' : ''}}>Paid</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-4 col-form-label">Status : <i class="text-danger">*</i> </label>
                                                        <div class="col-sm-8">
                                                            <select disabled class="form-control" id="unit" name="status" >
                                                                                                 
                                                                <option  value="1" {{$invoice->status == 1 ? 'selected' : ''}}>Active</option>
                                                                <option value="0" {{$invoice->status == 'Due' ? 'selected' : ''}}>Deactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                       
                                      
                                    </div>  
                                    
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label for="invoice_details" class="col-sm-2 col-form-label">Invoice Details : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-10">
                                                    <textarea disabled name="invoice_details" id="purchase_details" class="form-control" rows="4">{{$invoice->invoice_details}}</textarea>
                                                </div>
                                            </div> 
                                        </div>
                                    
                                    </div>
                                    <hr>
                                    {{-- <div class=" text-center">
                                        <h4> Select  Three of One . </h4>
                                    </div> --}}

                                    <div class="row">
                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-4 col-form-label">Sotre : </label>
                                                        <div class="col-sm-8">
                                                            {{-- <select class="form-control" id="inventory_id" name="inventory_id"  > --}}
                                                                                                        
                                                                @foreach ($locations as $location)
                                                              
                                                                    {{-- <option value="{{$location->id}}" {{$location->id ==  $inventoryId->inventory_id ? 'selected' : ''}}>{{$location->name}}</option> --}}
                                                                   
                                                                @if($location->id ==  $inventoryId->inventory_id)
                                                                <h4>{{$location->name}}</h4>
                                                                <input type="hidden" value="{{$location->id}}" name="inventory_id">
                                                               
                                                                
                                                                @endif

                                                                
                                                                @endforeach
                                                               
                                                            {{-- </select> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-4 col-form-label">Godown : </label>
                                                        <div class="col-sm-8">
                                                            {{-- <select class="form-control" id="godown_id" name="godown_id" > --}}
                                                                {{-- <option value="">Select One</option>                                           --}}
                                                                @foreach ($godowns as $godown)
                                                                {{-- <option value="{{$godown->id}}" {{$godown->id ==  $inventoryId->godown_id ? 'selected' : ''}}>{{$godown->name}}</option> --}}
                                                                @if($godown->id ==  $inventoryId->godown_id)
                                                                <h4>{{$godown->name}}</h4>
                                                                <input type="hidden" value="{{$godown->id}}" name="godown_id">
                                                               
                                                                @endif
                                                                @endforeach
                                                               
                                                            {{-- </select> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                      
                                    </div>
                                    <div class="row">

                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="direct_sell" class="col-sm-4 col-form-label">Direct Sell : </label>
                                                        <div class="col-sm-8">
                                                            {{-- <select class="form-control" id="direct_sell" name="direct_sell" > --}}
                                                                {{-- <option value="">Select One</option>                                           --}}
                                                                {{-- <option value="1" {{ $inventoryId->direct_sell == 1 ? 'selected' : ''}} >Direct Sell</option> --}}
                                                            {{-- </select> --}}
                                                            @if(1 ==  $inventoryId->direct_sell)
                                                                <h4>{{$inventoryId->direct_sell == 1 ? 'Direct Sell' : ''}}</h4>
                                                                <input type="hidden" value="1" name="direct_sell">
                                                               
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                       
                                     
                                  
                                </div>

                                   
          
         <hr style="border-top: 3px double #8c8b8b;">
                <div class="text-center"><h2>Customer Invoice No : {{$invoice->sell_invoice_no}}</h2></div>
                <div class="table-responsive" style="margin-top: 10px">
                    <table class="table table-bordered table-hover" id="purchaseTable">
                        <thead>
                             <tr>
                                 <th class="text-center" width="20%"> Item Name</th> 
                                      <th class="text-center">Size</th>
                                      <th class="text-center">Sell Qty</th>
                                    <th class="text-center">Return Qnty <i class="text-danger">*</i></th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Total</th>
                                    {{-- <th class="text-center">Action</th> --}}
                                </tr>
                        </thead>
                        <tbody id="table">
                            @foreach ($invoice_details as $invoice_detail)
                            <tr>
                                    <td class="span3 supplier">
                                            <select disabled class="form-control products_id" id="products_id_0" name="product_id[]" >
                                                    <option value="">Select One</option>                                          
                                                    @foreach ($products as $product)
                                                    <option value="{{$product->id}}" {{$product->id == $invoice_detail->product_id ? 'selected' : ''}}>{{$product->product_name}}</option>
                                                    @endforeach
                                                   
                                                </select>    
                                                
                                                @foreach ($products as $product)
                                                    @if ($product->id == $invoice_detail->product_id )
                                                        <input type="hidden" value="{{$product->id}}" name="product_id[]">
                                                    @endif
                                                @endforeach
                                    </td>  
                                    <td class="span3 supplier">
                                        <select readonly="readonly" class="form-control  product_size" required id="product_size" name="product_size[]" required="">
                                               
                                                @foreach ($productCft as $cft)
                                                @foreach ($productGrade as $grade)
                                                    @if($grade->id == $cft->grade_id)
                                                    @if($invoice_detail->product_size == $cft->id)
                                                    <option value="{{$cft->id}}">{{$cft->length.'x'.$cft->width.'x'.$cft->height.' '.$grade->name.' @'.$grade->price}}</option>
                                                    @endif
                                                    @endif
                                                @endforeach
                                                @endforeach
                                               
                                            </select>                              
                                </td>                  
                                   <td class="wt">
                                            <input readonly="readonly" name="sell_quantity" type="text" id="available_quantity_0" class="form-control text-right stock_ctn_1" value="{{$invoice_detail->quantity}}" readonly="" autocomplete="off">
                                        </td>
                                        <td class="text-right">
                                            <input type="text" name="return_sell_quantity[]" id="cartoon_1" class="form-control return_sell_quantity text-right "  value="" min="0" tabindex="6" autocomplete="off">
                                        </td>
                                        <td class="test">
                                            <input  readonly="readonly" type="text" name="sell_rate[]"  id="product_rate_1" class="form-control  sell_rate text-right"value="{{$invoice_detail->rate}}" min="0" tabindex="7" autocomplete="off">
                                        </td>
                                       
    
                                        <td class="text-right">
                                            <input class="form-control sell_total_price text-right" type="text" name="sell_total_price[]" id="total_price_1" value="" readonly="readonly" autocomplete="off">
                                        </td>
                                        {{-- <td>
    
                                           
    
                                            <button style="text-align: right;" class="btn btn-danger red" type="button" value="Delete" disabled  tabindex="8" autocomplete="off">Delete</button>
                                        </td> --}}
                                </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                                     <tr>
                               
                                <td style="text-align:right;" colspan="5"><b>Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="returnSubTotal" class="text-right form-control" name="total" value="" readonly="readonly" autocomplete="off">
                                </td>

                            </tr>
                            <tr>
                               
                                <td style="text-align:right;" colspan="4"><b>Cash Disount %</b></td>
                                @php
                                    
                                            $total =  $invoice->total_discount_two +  $invoice->total_amount + $invoice->total_discount;
                                            $total_discount = 0;
                                    @endphp

                                    @if ($total != 0)
                                        @php
                                            $total = $total - $invoice->others_price;
                                            
                                        @endphp   
                                        @if ($total != 0)
                                            @php
                                                $discount = $invoice->total_discount /$total ;
                                                $total_discount = $discount * 100;
                                            
                                            @endphp
                                        
                                        @endif  
                                    @endif


                                <td><input readonly="readonly" type="text" id="discount" name="discount_per" class="form-control text-right" value="{{round($total_discount,2)}}" autocomplete="off"></td>
                                <td class="text-right">
                                    <input type="text" id="totalDiscount" class="text-right form-control" name="discount_total" value="" readonly="readonly" autocomplete="off">
                                </td>

                            </tr>
                            <tr>
                               
                                    <td style="text-align:right;" colspan="4"><b>Special  Disount %</b></td>
                                         @php
                                    
                                            $total =  $invoice->total_discount_two +  $invoice->total_amount ;
                                            $total_discount_two = 0; 
                                         @endphp

                                         @if($total != 0)
                                            @php
                                            $total = $total - $invoice->others_price;
                                            @endphp
                                            @if($total != 0)
                                            @php
                                                $discount = $invoice->total_discount_two /$total ;
                                                $total_discount_two = $discount * 100;
                                               
                                                @endphp
                                            @endif
                                         @endif

                                    <td><input readonly="readonly" type="text" id="multidiscount" name="multi_dis" class="form-control text-right"  value="{{round($total_discount_two,2)}}" autocomplete="off"></td>
                                    <td class="text-right">
                                            
                                        <input type="text" id="multiTotalDiscount" class="text-right form-control" name="multi_dis_total" value="" readonly="readonly" autocomplete="off">
                                    </td>
    
                            </tr>
                
                            <tr>
                                {{-- <td colspan="2">
                                    <input type="button" id="addInput" class="btn btn-info"  value="Add New Item" tabindex="9" autocomplete="off">
                                     </td> --}}
                                <td style="text-align:right;" colspan="5"><b>Grand Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="sellGrandTotal" class="text-right form-control" name="sell_grand_total_price" value="" readonly="readonly" autocomplete="off">
                                </td>
                            </tr>
                            
                            <tr><td colspan="6"><b>In Word : :</b> <span id="inword"></span></td></tr>
                        </tfoot>
                    </table>
                </div>

              

                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="submit" id="add_purchase" class="btn btn-primary btn-large" value="Return" autocomplete="off">
                     </div>
                </div>
            </form>





  

@push('script')

<script src="{{asset('admin/assets/js/numberconverter.js')}}"></script>
<script>
$(document).ready(function(){
  


    
  

  
   

    
   



function returnSellCalculateTotal() {
    //Initialize total to 0
    var total = 0;
    $(".sell_total_price").each(function() {
      // Sum only if the text entered is number and greater than 0
      if (!isNaN(this.value) && this.value.length != 0) {
        total += parseFloat(this.value);
        $('#returnSubTotal').val(total.toFixed(2));
      }
    });

    
    
    var discount =  $("#discount").val();
    var multidiscount =  $("#multidiscount").val();
    var othersBill =  $("#othersBill").val();

    if(!isNaN(discount) && discount.length != 0){
      
     discount = total * discount;
     discount = discount/100;
     $("#totalDiscount").val(discount.toFixed(2));
     total = total - discount;
    }else{
        $("#totalDiscount").val(0);
    }

    if(!isNaN(multidiscount) && multidiscount.length != 0){
        
      multidiscount = total * multidiscount;
      multidiscount = multidiscount/100;
      $("#multiTotalDiscount").val(multidiscount.toFixed(2));
      total = total - multidiscount;
     }else{
        $("#multiTotalDiscount").val(0);
     }


  
    
    $('#sellGrandTotal').val(total.toFixed(2));

    var inwords = convertNumberToWords(total);
    document.getElementById("inword").innerHTML = inwords;
   
  }

 
  
  
  $(document).on("keydown keyup  keypress  change", ".return_sell_quantity", function() {
        var quantity    = $(this).val();
        var rat = $(this).parent().next().children().val();
        var sellQty = $(this).parent().prev().children().val();

        console.log(sellQty)

        if(parseInt(quantity) > parseInt(sellQty)){
            $(this).css('background-color','red');
        }else{
            $(this).css('background-color','transparent');
        }

       
        
        if(!isNaN(quantity) && quantity.length != 0){
            var total = rat * quantity;
            $(this).parent().next().next().children().val(total.toFixed(2))
           
        }else{
            $(this).parent().next().next().children().val(0)
        }
         returnSellCalculateTotal();
}); 


 

   

















});//end of document ready


  
</script>

@endpush