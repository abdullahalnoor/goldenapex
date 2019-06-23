
@extends('admin.master')

@section('title')
	purchase product
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

                    <a href="{{ url('/product/manage') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Manage Purchase Product </a>

                </div>
            </div>
        </div>
        <br>
            <form action="{{route('purchase.product')}}" class="form-vertical" id="insert_purchase" name="insert_purchase" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                        {{csrf_field()}}
            <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="supplier_id" class="col-sm-4 col-form-label">Supplier : </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="supplier_id" name="supplier_id" tabindex="3">
                                                        <option value="">--Select One--</option>
                                                        @foreach ($suppliers as $supplier)
                                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="purchase_date" class="col-sm-4 col-form-label">Purchase Date : </label>
                                                <div class="col-sm-8">
                                                    <input type="date"  class="form-control"name="purchase_date"    />
                                                </div>
                                            </div>
                                        </div>
            
                                    </div>
            
                                    <div class="row">

                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="payment_type" class="col-sm-4 col-form-label">Payment Type : </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="payment_type" name="payment_type" >
                                                                <option value="">Select One</option>                                          
                                                                <option value="Due">Due </option>
                                                                <option value="Paid">Paid</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="status" class="col-sm-4 col-form-label">Status : </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="status" name="status" >
                                                                <option value="">Select One</option>                                          
                                                                <option value="1">Active</option>
                                                                <option value="0">Deactive</option>
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
                                                            <select class="form-control" id="inventory_id" name="inventory_id" >
                                                                <option value="">Select One</option>                                          
                                                                @foreach ($locations as $location)
                                                                <option value="{{$location->id}}">{{$location->name}}</option>
                                                                @endforeach
                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label for="unit" class="col-sm-4 col-form-label">Godown : </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="godown_id" name="godown_id" >
                                                                <option value="">Select One</option>                                          
                                                                @foreach ($godowns as $godown)
                                                                <option value="{{$godown->id}}">{{$godown->name}}</option>
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
                                                        <input type="text"  class="form-control"  name="challan_no" placeholder="Challan No "  required />
                                                    </div>
                                                </div>
                                            </div>
                                  
                                </div>

                                    <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="purchase_details" class="col-sm-2 col-form-label">Purchase Details : <i class="text-danger">*</i> </label>
                                                    <div class="col-sm-10">
                                                        <textarea name="purchase_details" id="purchase_details" class="form-control" rows="4"></textarea>
                                                    </div>
                                                </div> 
                                            </div>
                                        
                                        </div>
          
         <hr style="border-top: 3px double #8c8b8b;">
                <div class="text-center"><h2>Supplier Invoice No : {{$newInvoiceID}}</h2></div>
                <div class="table-responsive" style="margin-top: 10px">
                    <table class="table table-bordered table-hover" id="purchaseTable">
                        <thead>
                             <tr>
                                 <th class="text-center" width="20%">Item code<i class="text-danger">*</i></th> 
                                      <th class="text-center">Stock/Qnt</th>
                                    <th class="text-center">Qnty <i class="text-danger">*</i></th>
                                    <th class="text-center">Rate<i class="text-danger">*</i></th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Action</th>
                                </tr>
                        </thead>
                        <tbody id="table">
                            <tr>
                                <td class="span3 supplier">
                                        <select class="form-control products_id" id="products_id_0" name="products_id[]" >
                                                <option value="">Select One</option>                                          
                                                @foreach ($products as $product)
                                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                                @endforeach
                                               
                                            </select>                              
                                </td>                    
                               <td class="wt">
                                        <input type="text" id="available_quantity_0" class="form-control text-right stock_ctn_1" placeholder="0.00" readonly="" autocomplete="off">
                                    </td>
                                    <td class="text-right">
                                        <input type="text" name="product_quantity[]" id="cartoon_1" class="form-control quantity text-right "  placeholder="0.00" value="" min="0" tabindex="6" autocomplete="off">
                                    </td>
                                    <td class="test">
                                        <input type="text" name="product_rate[]"  id="product_rate_1" class="form-control  product_rate text-right" placeholder="0.00" value="" min="0" tabindex="7" autocomplete="off">
                                    </td>
                                   

                                    <td class="text-right">
                                        <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" autocomplete="off">
                                    </td>
                                    <td>

                                       

                                        <button style="text-align: right;" class="btn btn-danger red" type="button" value="Delete" disabled  tabindex="8" autocomplete="off">Delete</button>
                                    </td>
                            </tr>
                        </tbody>
                        <tfoot>
                                     <tr>
                                        <td colspan="2">
                                            <input type="button" id="addInput" class="btn btn-info"  value="Add New Item" tabindex="9" autocomplete="off">
                                             </td>
                                <td style="text-align:right;" colspan="2"><b>Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="subTotal" class="text-right form-control" name="total" value="0.00" readonly="readonly" autocomplete="off">
                                </td>

                            </tr>
                            <tr>
                               
                                <td style="text-align:right;" colspan="3"><b>Cash Disount %</b></td>
                                <td><input type="text" id="discount" name="dis_percent" class="form-control text-right"  placeholder="0.00" autocomplete="off"></td>
                                <td class="text-right">
                                    <input type="text" id="totalDiscount" class="text-right form-control" name="tdiscount" value="0.00" readonly="readonly" autocomplete="off">
                                </td>

                            </tr>
                            <tr>
                                
                                <td style="text-align:right;" colspan="4"><b>Grand Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="grandTotal" class="text-right form-control" name="grand_total_price" value="0.00" readonly="readonly" autocomplete="off">
                                </td>
                            </tr>
                            <tr><td colspan="6"><b>In Word : :</b> <span id="inword"></span></td></tr>
                        </tfoot>
                    </table>
                </div>

              

                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="submit" id="add_purchase" class="btn btn-primary btn-large" value="Submit" autocomplete="off">
                     </div>
                </div>
            </form>

<!-- Add Product End -->
@endsection


@include('admin.purchase-product.alert')

<div id="modal">

</div>
  

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
                                       '<select class="form-control products_id" id="products_id_'+max+'" name="products_id[]" >'+
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
        
        
      

        if(!isNaN(inventory_id) && !isNaN(godown_id)){
            if(inventory_id.length != 0 && godown_id.length != 0){
               
                // $("#purchaseTable").load(location.href + " #table");
                
                $("#godown_id").val('');
                $("#inventory_id").val('');
                $("#alertMessage").modal("show");             
            }
        }

        if(inventory_id == '' && godown_id == ''){
            // $("#purchaseTable").load(location.href + " #table");
            $("#"+id).val('');
            $("#alertMessage").modal("show"); 
           
        }



        if(!inventory_id == '' && godown_id == ''){
           
            console.log(val);
            console.log(id);
            if(!val == '' && id != ''){
           
            console.log('111');
            
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


        // if



    }
    $(document).on("keyup keypress keydown change",".products_id",function(e){
        e.preventDefault();
        var id = $(this).attr("id");
        var val = $(this).val();
        // var ids = e.target.value;
        // console.log(id);
        fetchProductInfo(val,id);

    }) 
    $(document).on("keyup keypress keydown change","#inventory_id",function(e){
        e.preventDefault();available_quantity_0
        $("#products_id_0").val('');
        $("#available_quantity_0").val('');
        $("#table .removeInputs").each(function() {
            $(this).parent().parent().remove();
        })
        fetchProductInfo();
    })


    $(document).on("keyup keypress keydown change","#godown_id",function(e){
        e.preventDefault();
        $("#products_id_0").val('');
        $("#available_quantity_0").val('');
        $("#table .removeInputs").each(function() {
            $(this).parent().parent().remove();
        })
        fetchProductInfo();
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
    var vat =  $("#vat").val();

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
      total = total - multidiscount;
     }


     if(!isNaN(vat) && vat.length != 0){
      
      vat = total * vat;
      vat = vat/100;
      total = total + vat;
     }
    
    $('#grandTotal').val(total.toFixed(2));

    var inwords = convertNumberToWords(total);
    document.getElementById("inword").innerHTML = inwords;
  }

 
  
  
  $("body").on("keyup keypress change", "#vat", function() {
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