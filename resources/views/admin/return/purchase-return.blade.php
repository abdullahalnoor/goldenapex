<section class="content">
        
        <br>
            <form action="{{route('submit.return.purchase.product')}}" class="form-vertical" id="insert_purchase" name="insert_purchase" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                        {{csrf_field()}}
            <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="supplier_id" class="col-sm-4 col-form-label">Supplier : </label>
                                                <div class="col-sm-8">
                                                    <select disabled class="form-control" id="supplier_id" name="supplier_id" tabindex="3">
                                                        @foreach ($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}" {{$product_purchase->supplier_id == $supplier->id ? 'selected' : ''}} >{{$supplier->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="purchase_date" class="col-sm-4 col-form-label">Purchase Date : </label>
                                                <div class="col-sm-8">
                                                    <input type="date" disabled class="form-control"name="purchase_date"  value="{{$product_purchase->purchase_date}}"   />
                                                    <input type="hidden"  name="purchase_id"  value="{{$product_purchase->id}}"   />
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
                                                                <option value="">Select One</option>                                          
                                                                <option value="Due" {{$product_purchase->payment_type == 'Due' ? 'selected' : ''}}>Due </option>
                                                                <option value="Paid" {{$product_purchase->payment_type == 'Paid' ? 'selected' : ''}}>Paid</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-4 col-form-label">Status : </label>
                                                        <div class="col-sm-8">
                                                            <select disabled class="form-control" id="unit" name="status" >
                                                                <option value="">Select One</option>                                          
                                                                <option value="1" {{$product_purchase->status == 1 ? 'selected' : ''}}>Active</option>
                                                                <option value="0" {{$product_purchase->status == 0 ? 'selected' : ''}}>Deactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                       
                                      
                                    </div>                        
                                    <div class="row">
                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-4 col-form-label">Sotre : </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="inventory_id" name="inventory_id" disabled  >
                                                                <option value="">Select One</option>                                          
                                                                @foreach ($locations as $location)
                                                                <option value="{{$location->id}}" {{$location->id == $inventoryId->inventory_id ? 'selected' : ''}}>{{$location->name}}</option>
                                                                @endforeach
                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-4 col-form-label">Godown : </label>
                                                        <div class="col-sm-8">
                                                            <select disabled class="form-control" id="godown_id" name="godown_id" disabled >
                                                                <option value="">Select One</option>                                          
                                                                @foreach ($godowns as $godown)
                                                                <option value="{{$godown->id}}" {{$godown->id == $inventoryId->godown_id ? 'selected' : ''}}>{{$godown->name}}</option>
                                                                @endforeach
                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                      
                                    </div>
                                    <div class="row">
                                       
                                        <div class="col-sm-6">
                                                <div class="form-group row">
                                                    <label for="challan_no" class="col-sm-4 col-form-label">Challan No : </label>
                                                    <div class="col-sm-8">
                                                        <input disabled type="text"  class="form-control"  name="challan_no" value="{{$product_purchase->challan_no}}"  required />
                                                    </div>
                                                </div>
                                            </div>
                                  
                                </div>

                                    <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="purchase_details" class="col-sm-2 col-form-label">Purchase Details : <i class="text-danger">*</i> </label>
                                                    <div class="col-sm-10">
                                                        <textarea name="purchase_details" disabled id="purchase_details" class="form-control" rows="4">{{$product_purchase->purchase_details}}</textarea>
                                                    </div>
                                                </div> 
                                            </div>
                                        
                                        </div>
                                   <input type="hidden" value="{{$product_purchase->id}}" name="purchase_id">
                                    
                                  
                                   <input type="hidden" value="{{$location_id}}" name="location_id">
                                  
                                   <input type="hidden" value="{{$godown_id}}" name="godown_id">
                                   
                                       
          
         <hr style="border-top: 3px double #8c8b8b;">
                <div class="text-center"><h2>Supplier Invoice No : {{$product_purchase->purchase_invoice_no}}</h2></div>
                <div class="table-responsive" style="margin-top: 10px">
                    <table class="table table-bordered table-hover" id="purchaseTable">
                        <thead>
                             <tr>
                                 <th class="text-center" width="20%">Item Name</th> 
                                      <th class="text-center">Purchase Qty</th>
                                    <th class="text-center">Return Qty <i class="text-danger">*</i></th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Check <br> Return <i class="text-danger">*</i></th>
                                    {{-- <th class="text-center">Action</th> --}}
                                </tr>
                        </thead>
                        <tbody id="table">

                            @foreach ($product_purchase_details as $purchase_details)
                            <tr>
                                <td class="span3 supplier">
                                        <select disabled class="form-control products_id" id="products_id_0" name="products_id[]" >
                                                                                     
                                                @foreach ($products as $product)
                                                <option value="{{$product->id}}" {{$purchase_details->product_id == $product->id ? 'selected' : ''}}>{{$product->product_name}}</option>
                                                @endforeach
                                               
                                            </select>                              
                                </td>                    
                               <td class="wt">
                                    <input disabled type="text" name="purchase_quantity[]"  id="cartoon_1" class="form-control purchase_quantity text-right "   value="{{$purchase_details->quantity}}" autocomplete="off">
                                </td>
                                    <td class="text-right">
                                        <input type="text" name="purchase_return_quantity[]"  id="cartoon_1" class="form-control purchase_return_quantity text-right "   value="" autocomplete="off">
                                    </td>
                                    <td class="test">
                                        <input disabled type="text" name="purchase_rate[]"  id="product_rate_1" class="form-control  purchase_rate text-right" value="{{$purchase_details->rate}}" autocomplete="off">
                                    </td>
                                   

                                    <td class="text-right">
                                        <input class="form-control purchase_total_price text-right" type="text" name="purchase_total_price[]" id="total_price_1" value="" readonly="readonly" autocomplete="off">
                                    </td>
                                    <td class="text-right">
                                            @foreach ($products as $product)
                                            @if ($purchase_details->product_id == $product->id)
                                          
                                            <input type="checkbox" class="form-control" name="vehicle1" value="Bike">
                                            <input type="hidden" name="purchase_product_id[]" value="{{$product->id}}"> 
                                            @endif
                                            
                                               @endforeach
                                    </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                                     <tr>
                               
                                <td style="text-align:right;" colspan="4"><b>Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="purchaseSubTotal" class="text-right form-control" name="total" value="" readonly="readonly" autocomplete="off">
                                </td>

                            </tr>
                            <tr>
                               
                                <td style="text-align:right;" colspan="3"><b>Cash Disount %</b>
                                
                                @php
                                    
                                   $total =  $product_purchase->total_discount +  $product_purchase->grand_total_amount;
                                   $discount = $product_purchase->total_discount /$total ;
                                   $discount_per = $discount * 100;
                                @endphp
                                
                                </td>
                                <td><input disabled type="text" id="purchase_product_dis_percent" name="purchase_product_dis_percent" class="form-control text-right" value="{{$discount_per}}"  autocomplete="off"></td>
                                <td class="text-right">
                                    <input type="text" id="purchaseTotalDiscount" class="text-right form-control" name="tdiscount" value="" readonly="readonly" autocomplete="off">
                                </td>

                            </tr>
                            <tr>
                                {{-- <td colspan="2">
                                    <input type="button" id="addInput" class="btn btn-info"  value="Add New Item" tabindex="9" autocomplete="off">
                                     </td> --}}
                                <td style="text-align:right;" colspan="4"><b>Grand Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="purchaseGrandTotal" class="text-right form-control" name="purchase_grand_total_price" value=""  readonly="readonly" autocomplete="off">
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


    </section>

    @push('script')

<script src="{{asset('admin/assets/js/numberconverter.js')}}"></script>
<script>


$(document).ready(function(){


    function calculatePurchaseReturnTotal() {
    //Initialize total to 0
    var total = 0;
    $(".purchase_total_price").each(function() {
      // Sum only if the text entered is number and greater than 0
      if (!isNaN(this.value) && this.value.length != 0) {
        total += parseFloat(this.value);
      }
    });

    $('#purchaseSubTotal').val(total.toFixed(2));
    
    var discount =  $("#purchase_product_dis_percent").val();
    // var multidiscount =  $("#multidiscount").val();
    // var vat =  $("#vat").val();

    if(!isNaN(discount) && discount.length != 0){
      
     discount = total * discount;
     discount = discount/100;
     $("#purchaseTotalDiscount").val(discount.toFixed(2));
     total = total - discount;
    }else{
        $("#purchaseTotalDiscount").val(0);
    }
    // console.log($("#purchase_product_dis_percent").val());


   
    
    $('#purchaseGrandTotal').val(total.toFixed(2));

    var inwords = convertNumberToWords(total);
    document.getElementById("inword").innerHTML = inwords;
  }


    $(document).on("keyup keypress keydown change", ".purchase_return_quantity", function() {
        var purchaseQty = $(this).parent().prev().children().val();
        // console.log(purchaseQty);
        var quantity    = $(this).val();
        // console.log(quantity);


        if ( parseInt(quantity) > parseInt(purchaseQty)  ) {
            $(this).css('background-color','red');
        }else{
            $(this).css('background-color','transparent');
        }

        // purchase_product_dis_percent
        var price   =$(this).parent().next().children().val();
        // console.log(price);
        // $(this).parent().next().children().css('background-color','red');
        // $(this).parent().prev().children().css('background-color','red');
        // .css('background-color','red');
        // var total ;

        console.log($("#purchase_product_dis_percent").val());

        if (!isNaN(quantity) && quantity.length != 0) {
           total = parseFloat(price * quantity);
           $(this).parent().next().next().children().val(total);
           
         }else{
          $(this).parent().next().next().children().val(0);
         }
         calculatePurchaseReturnTotal();
    
    });  




})


</script>

@endpush   