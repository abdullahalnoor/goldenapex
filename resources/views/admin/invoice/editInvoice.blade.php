
@extends('admin.master')

@section('title')
Update Invoice
@endsection

@section('mainContent')

        <!-- Alert Message -->
        <div class="row">
            <div class="col-sm-12">
            @if(Session::has('danger'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <div class="text-center" style="font-size: 18px; padding: 9px; border: 2px solid red;">
                     {{ Session::get('danger') }}
                    </div>
                </div>
            @endif
            </div>
        </div>
        <!-- end Message -->
<br>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="column">

                    <a href="{{ url('/invoice/manage') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Manage Invoice </a>

                </div>
            </div>
        </div>
        <br>
            <form action="{{url('/invoice/update')}}" class="form-vertical" id="insert_purchase" name="insert_purchase" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                        {{csrf_field()}}
            <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="customer_id" class="col-sm-4 col-form-label">customer : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" id="customer_id" name="customer_id" tabindex="3">
                                                        <option value="">--Select One--</option>
                                                        @foreach ($customer_info as $customer)
                                                        <option value="{{$customer->id}}" {{$customer->id == $invoice->customer_id ? 'selected' : ''}}>{{$customer->customer_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="invoice_detail_id" value="{{$invoice->id}}" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="date" class="col-sm-4 col-form-label">Sell Date : <i class="text-danger">*</i> </label>
                                                <div class="col-sm-8">
                                                    <input type="date"  class="form-control"name="date" value="{{$invoice->date}}"   />
                                                </div>
                                            </div>
                                        </div>
            
                                    </div>
            
                                    <div class="row">

                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="payment_type" class="col-sm-4 col-form-label">Payment Type : </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control select2" id="payment_type" name="payment_type" >
                                                                <option value="">Select One</option>                                          
                                                                <option value="Due" {{$invoice->payment_type == 'Due' ? 'selected' : ''}}>Due </option>
                                                                <option value="Paid" {{$invoice->payment_type == 'Paid' ? 'selected' : ''}}>Paid</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-4 col-form-label">Status :  </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control select2" id="unit" name="status" >
                                                                <option value="">Select One</option>                                          
                                                                <option value="1" {{$invoice->status == 1 ? 'selected' : ''}}>Active</option>
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
                                                    <textarea name="invoice_details" id="purchase_details" class="form-control" rows="4">{{$invoice->invoice_details}}</textarea>
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
                                 <th class="text-center" width="20%">Select Item <i class="text-danger">*</i></th> 
                                      <th class="text-center">Stock</th>
                                    <th class="text-center">Qnty <i class="text-danger">*</i></th>
                                    <th class="text-center">Rate<i class="text-danger">*</i></th>
                                    <th class="text-center">Total</th>
                                    {{-- <th class="text-center">Action</th> --}}
                                </tr>
                        </thead>
                        <tbody id="table">
                            @foreach ($invoice_details as $invoice_detail)
                            <tr>
                                    <td class="span3 supplier">
                                            <select class="form-control products_id" id="products_id_0" name="product_id[]" >
                                                    <option value="">Select One</option>                                          
                                                    @foreach ($products as $product)
                                                    <option value="{{$product->id}}" {{$product->id == $invoice_detail->product_id ? 'selected' : ''}}>{{$product->product_name}}</option>
                                                    @endforeach
                                                   
                                                </select>                              
                                    </td>                    
                                   <td class="wt">
                                            <input type="text" id="available_quantity_0" class="form-control text-right stock_ctn_1" value="{{$invoice_detail->availableQty($invoice_detail)}}" readonly="" autocomplete="off">
                                        </td>
                                        <td class="text-right">
                                            <input type="text" name="product_quantity[]" id="cartoon_1" class="form-control quantity text-right "  value="{{$invoice_detail->quantity}}" min="0" tabindex="6" autocomplete="off">
                                        </td>
                                        <td class="test">
                                            <input type="text" name="product_rate[]"  id="product_rate_1" class="form-control  product_rate text-right"value="{{$invoice_detail->rate}}" min="0" tabindex="7" autocomplete="off">
                                        </td>
                                       
    
                                        <td class="text-right">
                                            <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="{{$invoice_detail->quantity * $invoice_detail->quantity}}" readonly="readonly" autocomplete="off">
                                        </td>
                                        {{-- <td>
    
                                           
    
                                            <button style="text-align: right;" class="btn btn-danger red" type="button" value="Delete" disabled  tabindex="8" autocomplete="off">Delete</button>
                                        </td> --}}
                                </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                                     <tr>
                               
                                <td style="text-align:right;" colspan="4"><b>Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="subTotal" class="text-right form-control" name="total" value="{{($invoice->total_amount + $invoice->total_discount +$invoice->total_discount_two) - $invoice->others_price }} " readonly="readonly" autocomplete="off">
                                </td>

                            </tr>
                            <tr>
                               
                                <td style="text-align:right;" colspan="3"><b>Cash Disount %</b></td>
                                @php
                                    
                                            $total =  $invoice->total_discount_two +  $invoice->total_amount + $invoice->total_discount;
                                            $total = $total - $invoice->others_price;
                                            $discount = $invoice->total_discount /$total ;
                                            $total_discount = $discount * 100;
                                    @endphp
                                <td><input type="text" id="discount" name="discount_per" class="form-control text-right" value="{{round($total_discount,2)}}" autocomplete="off"></td>
                                <td class="text-right">
                                    <input type="text" id="totalDiscount" class="text-right form-control" name="tdiscount" value="{{round($invoice->total_discount,2)}}" readonly="readonly" autocomplete="off">
                                </td>

                            </tr>
                            <tr>
                               
                                    <td style="text-align:right;" colspan="3"><b>Special  Disount %</b></td>
                                    @php
                                    
                                            $total =  $invoice->total_discount_two +  $invoice->total_amount ;
                                            $total = $total - $invoice->others_price;
                                            $discount = $invoice->total_discount_two /$total ;
                                            $total_discount_two = $discount * 100;
                                         @endphp
                                    <td><input type="text" id="multidiscount" name="multi_dis" class="form-control text-right"  value="{{round($total_discount_two,2)}}" autocomplete="off"></td>
                                    <td class="text-right">
                                            
                                        <input type="text" id="multiTotalDiscount" class="text-right form-control" name="tdiscount" value="{{round($invoice->total_discount_two,2)}}" readonly="readonly" autocomplete="off">
                                    </td>
    
                            </tr>
                            <tr>
                               
                                    <td style="text-align:right;" colspan="2"><b>Miscellaneous : </b></td>
                                    <td colspan="2"><input type="text"  name="others_bill" class="form-control text-right" value="{{$invoice->others_bill}}" autocomplete="off"></td>
                                    <td class="text-right">
                                        <input type="text" id="othersBill" class="text-right form-control" name="others_price" value="{{$invoice->others_price}}" >
                                    </td>
    
                            </tr>
                            <tr>
                                {{-- <td colspan="2">
                                    <input type="button" id="addInput" class="btn btn-info"  value="Add New Item" tabindex="9" autocomplete="off">
                                     </td> --}}
                                <td style="text-align:right;" colspan="4"><b>Grand Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="{{round($invoice->total_amount,2)}} " readonly="readonly" autocomplete="off">
                                </td>
                            </tr>
                            
                            <tr><td colspan="6"><b>In Word : :</b> <span id="inword"></span></td></tr>
                        </tfoot>
                    </table>
                </div>

              

                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="submit" id="add_purchase" class="btn btn-primary btn-large" value="Update" autocomplete="off">
                     </div>
                </div>
            </form>

<!-- Add Product End -->
@include('admin.purchase-product.alert')

<div id="modal">

</div>
@endsection



  

@push('script')

<script src="{{asset('admin/assets/js/numberconverter.js')}}"></script>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var max = 1;
$(document).on("click","#addInput",function(e){
    e.preventDefault();
                       
      $('#table').append(
                        '<tr>'+
                                '<td class="span3 supplier">'+
                                       '<select class="form-control products_id" id="products_id_'+max+'" name="product_id[]" >'+
                                                '<option value="">Select One</option>' +                                         
                                                '@foreach ($products as $product)'+
                                                '<option value="{{$product->id}}">{{$product->product_name}}</option>'+
                                                '@endforeach'+                                       
                                            '</select>' +                  
                                '</td>'+                            
                              ' <td class="wt">'+
                                        '<input type="text" id="'+max+'" class="form-control text-right stock_ctn_1" placeholder="0.00" readonly="" autocomplete="off">'+
                                    '</td>'+
                                    '<td class="text-right">'+
                                        '<input type="text" name="product_quantity[]" id="cartoon_1" class="form-control quantity text-right "  placeholder="0.00" value="" min="0" tabindex="6" autocomplete="off">'+
                                    '</td>'+
                                   ' <td class="test">'+
                                        '<input type="text" name="product_rate[]"  id="product_rate_1" class="form-control  product_rate text-right" placeholder="0.00" value="" min="0" tabindex="7" autocomplete="off">'+
                                    '</td> ' +  
                                    '<td class="text-right">'+
                                       ' <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" autocomplete="off">'+
                                    '</td>'+
                                    '<td>'+
                                        '<button style="text-align: right;" class="btn btn-danger removeInputs red" type="button" value="Delete"   tabindex="8" autocomplete="off">Delete</button>'+
                                    '</td>'+
                            '</tr>'
      );
    max ++;
   
})
    
  function  fetchProductInfo(val = null,id = null){
        var inventory_id = $("#inventory_id").val();
        var inventory = $("#inventory_id").attr("id");
        var godown_id = $("#godown_id").val();
        var godown = $("#godown_id").attr("id");
        
        var direct_sell = $("#direct_sell").val();
      
       

        

        if(inventory_id == '' && godown_id == '' && direct_sell == ''){
            // $("#purchaseTable").load(location.href + " #table");
            $("#"+id).val('');
            $("#alertMessage").modal("show"); 
           
        }


        if(!direct_sell == '' ){
            // nothing to do    
        }else{

                if(!inventory_id == '' && godown_id == ''){
                
                    console.log(val);
                    console.log(id);
                    if(!val == '' && id != ''){
                
                    
                    
                    var  route  = "{{url('get/product-info/')}}"+'/'+val+'/'+inventory_id+'/inventory';
                    console.log(route);

                        $.get(route,function(data){
                            // available_quantity_0
                            // $("#"+id).parent().next().children().css('background-color','red');
                        
                            $("#"+id).parent().next().children().val(data.purchase_qty);
                            // parent().next().children()
                            console.log(data.purchase_qty);
                            // $("#"+id).val(data.purchase_qty);
                            
                        });


                    }
                    
                }

                if(inventory_id == '' && !godown_id == ''){
                
                console.log(val);
                console.log(id);
                if(!val == '' && id != ''){
                
                console.log('111');
                
                var  route  = "{{url('get/product-info/')}}"+'/'+val+'/'+godown_id+'/godown';
                console.log(route);

                    $.get(route,function(data){
                        // available_quantity_0
                        // $("#"+id).parent().next().children().css('background-color','red');
                        $("#"+id).parent().next().children().val(data.purchase_qty);
                        // parent().next().children()
                        console.log(data.purchase_qty);
                        // $("#"+id).val(data.purchase_qty);
                    });


                }
                
            }

        }
        
    }

    $(document).on("keyup keypress keydown change",".products_id",function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        var val = $(this).val();
        // var ids = e.target.value;
        // console.log(id);
        fetchProductInfo(val,id);

    }) 

    function cleanDynamicInputs(){
        $("#products_id_0").val('');
        $("#available_quantity_0").val('');
        $("#table .removeInputs").each(function() {
            $(this).parent().parent().remove();
        })
    };
    
    $(document).on("keyup keypress keydown change","#direct_sell",function(e){
        e.preventDefault();
        $("#inventory_id").val('');
        $("#godown_id").val('');

        cleanDynamicInputs();
        fetchProductInfo();
    })

    $(document).on("keyup keypress keydown change","#inventory_id",function(e){
        e.preventDefault();
        $("#direct_sell").val('');
        $("#godown_id").val('');
        cleanDynamicInputs();
        fetchProductInfo();
    })


    $(document).on("keyup keypress keydown change","#godown_id",function(e){
        e.preventDefault();
        $("#direct_sell").val('');
        $("#inventory_id").val('');

        cleanDynamicInputs();
        fetchProductInfo()
        
    })

    
   



function calculateTotal() {
    //Initialize total to 0
    var total = 0;
    $(".total_price").each(function() {
      // Sum only if the text entered is number and greater than 0
      if (!isNaN(this.value) && this.value.length != 0) {
        total += parseFloat(this.value);
      }
    });

    $('#subTotal').val(total.toFixed(2));
    
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


     if(!isNaN(othersBill) && othersBill.length != 0){
      total = total + parseInt(othersBill) ;
     }
    
    $('#grandTotal').val(total.toFixed(2));

    var inwords = convertNumberToWords(total);
    document.getElementById("inword").innerHTML = inwords;
   
  }

 
  
  
  $("body").on("keyup keypress change", "#othersBill", function() {
        var vat    = $(this).val();
         calculateTotal();
    }); 


  $("body").on("keyup keypress change", "#discount", function() {
        var discount    = $(this).val();
         calculateTotal();
    });  

    $("body").on("keyup keypress change", "#multidiscount", function() {
        var discount    = $(this).val();
         calculateTotal();
    });  
    

    $("#table").on("click", ".removeInputs", function(e) {
      e.preventDefault();
      $(this).parent().parent().remove();

        calculateTotal();
      
    });  

   

$(document).on("keyup keypress keydown change", ".quantity", function() {
        var quantity    = $(this).val();
        var price   =$(this).parent().next().children().val();
        var total ;

        if (!isNaN(price) && price.length != 0) {
           total = parseFloat(price * quantity);
           $(this).parent().next().next().children().val(total);
           
         }else{
          $(this).parent().next().next().children().val(0);
         }
         calculateTotal();
    
    });  


    $(document).on("keyup keypress keydown change ", ".product_rate", function() {
        var price    = $(this).val();
        var quantity   =$(this).parent().prev().children().val();
        var total ;
        if (!isNaN(price) && price.length != 0) {
           total = parseFloat(price * quantity);
           $(this).parent().next().children().val(total);
           
         }else{
          $(this).parent().next().children().val(0);
         }
         calculateTotal();
    });  















});//end of document ready


  
</script>

@endpush