@extends('admin.master')

@section('mainContent')

@section('title')
	Manage Purchase Product
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
      <!-- end Message -->
        
        <div class="row">
            <div class="col-sm-12">
                <div class="column">
                    <a href="{{ route('purchase.product') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> Purchase  Product </a>
                </div>
            </div>
        </div>
    <br>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> All Products Information </div>
            <div class="card-body">


               
                <div class="table-responsive">
                    <table id="default-datatable" class="table table-bordered">
                      <thead>
                          <tr class="text-center">                  
                            <th>Item Name</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>Stock</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($stocks as $stock)
                           <tr>
                            <td>
                                @foreach ($products as $product)
                                {{$product->id == $stock->product_id ? $product->product_name : '' }}
                            @endforeach
                            </td>
                            <td>{{$stock->purchase_qty}}</td>
                            <td>{{$stock->sell_qty}}</td>
                            @php($stockTotal = $stock->purchase_qty - $stock->sell_qty)
                            <td>{{$stockTotal}}</td>
                           </tr>
                        @endforeach
                      </tbody>
               
              </table>
           
            </div>
          

          
            
                
       
            </div>
          </div>
        </div>
      </div><!-- End Row-->

@endsection

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
  </script>


