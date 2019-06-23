@extends('employee.master')

@section('title')
    Add New Order
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
        <div class="card  border-primary">
            <div class="card-body">
                <div class="card-title"> <i class="fa fa-plus"></i> Add New Order</div>
                <hr>
            <form action="{{url('/employee/order/save')}}" class="form-vertical" id="insert_purchase" name="insert_purchase" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate">
                        {{csrf_field()}}
                <div class="text-center"><h3>ORDER NO : {{$newInvoiceID}}</h3></div>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="customer_id" class="col-sm-4 col-form-label">customer :  <i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <select class="form-control" id="customer_id" name="customer_id" tabindex="3" required>
                                    <option value="">--Select One--</option>
                                        @foreach ($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label for="date" class="col-sm-4 col-form-label">Order Date :  <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input type="date" required class="form-control"name="date"    />
                                </div>
                        </div>
                    </div>
                </div>

                <hr>
                <br>
                <div class="table-responsive" style="margin-top: 10px">
                    <table class="table table-bordered table-hover" id="purchaseTable">
                        <thead>
                             <tr>
                                 <th class="text-center" width="20%">Item Type<i class="text-danger">*</i></th> 
                                      <th class="text-center">Item Name<i class="text-danger">*</i></th>
                                    <th class="text-center">Qnty <i class="text-danger">*</i></th>
                                    <th class="text-center">Rate<i class="text-danger">*</i></th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Material</th>
                                    <th class="text-center">Action</th>
                                </tr>
                        </thead>
                        <tbody id="table">
                            <tr>
                                <td class="span3" style="width: 100px;">
                                    <select class="form-control products_id" required id="products_id_0" name="item_type[]" >
                                        <option value="">Select One</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>       
                                    </select>                              
                                </td>                    
                               <td style="width: 230px;">
                                    <input type="text" name="item_name[]" required  class="form-control quantity"  placeholder="Item Name" tabindex="6" autocomplete="off">
                                </td>
                                    <td class="text-right">
                                        <input type="text" name="product_quantity[]" required id="cartoon_1" class="form-control quantity text-right "  placeholder="0.00" value="" min="0" tabindex="6" autocomplete="off">
                                    </td>
                                    <td class="test" style="width: 150px;">
                                        <input type="text" name="product_rate[]" required id="product_rate_1" class="form-control  product_rate text-right" placeholder="0.00" value="" min="0" tabindex="7" autocomplete="off">
                                    </td>
                                   

                                    <td class="text-right" style="width: 150px;">
                                        <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" autocomplete="off">
                                    </td>

                                    <td class="test" style="width: 150px;">
                                        <input type="text" name="product_mate[]" id="product_mate" class="form-control  product_mate " placeholder="Material" value="" tabindex="9" autocomplete="off">
                                    </td>

                                    <td>
                                        <button style="text-align: right;" class="btn btn-danger red" type="button" value="Delete" disabled  tabindex="8" autocomplete="off">Delete</button>
                                    </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <input type="button" id="addInput" class="btn btn-info"  value="Add New Item" tabindex="9" autocomplete="off">
                                </td>

                                <td style="text-align:right;" colspan="3"><b>Grand Total:</b></td>
                                <td class="text-right">
                                    <input type="text" id="subTotal" class="text-right form-control" name="grand_total" value="0.00" readonly="readonly" autocomplete="off">
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    
                </div>   
                <br>         
                <div class="form-group row">
                    <label for="input-1" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary shadow-primary px-5"></i> Save</button>
                </div>
            </form>
            </div>                            
        </div>
@endsection


@push('script')

<script>

    $().ready(function() {

    $("#personal-info").validate();

//    validation  form on keyup and submit
    $("#insert_purchase").validate({
        rules: {
            
            "product_quantity[]" : {
                required: true,
                minlength: 1,
            },
            
            username: {
                required: true,
                minlength: 2
            },
            
        },
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
          
            topic: "Please select at least 2 topics"
        }
    });

   

});

    </script>

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
                                       '<select class="form-control" id="products_id_'+max+'" name="item_type[]" required>'+
                                                '<option value="">Select One</option>' +
                                                '<option value="A">A</option>' +
                                                '<option value="B">B</option>' +
                                                '<option value="C">C</option>' +

                                            '</select>' +                  
                                '</td>'+                            
                              ' <td class="wt">'+
                                        '<input type="text" id="'+max+'" class="form-control stock_ctn_1" placeholder="Item Name" name="item_name[]" required autocomplete="off">'+
                                    '</td>'+
                                    '<td class="text-right">'+
                                        '<input type="text" name="product_quantity[]"  id="cartoon_1" class="form-control quantity text-right "  placeholder="0.00"   autocomplete="off" >'+
                                    '</td>'+
                                   ' <td class="test">'+
                                        '<input type="text" name="product_rate[]"  id="product_rate_1" class="form-control  product_rate text-right" placeholder="0.00"  autocomplete="off">'+
                                    '</td> ' +  
                                    '<td class="text-right">'+
                                       ' <input class="form-control total_price text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" autocomplete="off">'+
                                    '</td>'+

                                    '<td>'+
                                       ' <input class="form-control" type="text" name="product_mate[]" id="total_price_1" placeholder="Material" autocomplete="off">'+
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