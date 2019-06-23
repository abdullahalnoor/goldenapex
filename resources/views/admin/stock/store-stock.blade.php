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


                @foreach ($stocks as $key => $items)
                @php($var =$key )
                
                @foreach ($locations as $location)
                  
                     <h2 class="text-center"> {{$location->id ==  $key ?'Store : '.$location->name : '' }}</h2>
                 
                @endforeach  
                <hr>
                <div class="table-responsive">
                    <table  class="table table-bordered">
                      <thead>
                          <tr class="text-center">                  
                            <th>Item Name</th>
                            <th>In Qty</th>
                            <th>Out Qty</th>
                            <th>Stock Qty</th>
                          </tr>
                      </thead>
                
                @foreach ($items as  $child)
                <tr>
                    <td>
                      @foreach ($products as $product)
                       {{ $child->product_id == $product->id ? $product->product_name : '' }}
                      @endforeach
                    </td>
                    
                <td>{{ $child->purchase_qty + $child->sell_qty }}</td>
                <td>{{ $child->sell_qty }}</td>
                @php( $totalStock = $child->purchase_qty + $child->sell_qty  )
                @php( $totalStock -=  $child->sell_qty  )
                <td>{{ $totalStock }}</td>
              </tr>
                @endforeach
              </table>
           
            </div>
            <br><br>
            @endforeach

          
            
          



       
            </div>
          </div>
        </div>
      </div><!-- End Row-->
      
@endsection

@push('script')
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
  </script>
@endpush


