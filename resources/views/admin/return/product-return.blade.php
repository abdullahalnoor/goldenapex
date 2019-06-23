@extends('admin.master')

@section('title')
	Return Product
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

        
      <!-- Alert Message -->
     

    <div class="row">
        <div class="col-sm-12">
        @if(Session::has('succes'))
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <div class="text-center" style="font-size: 18px; padding: 9px; border: 2px solid #00B1E6;">
                 {{ Session::get('succes') }}
                </div>
            </div>
        @endif
        </div>
    </div>
    <!-- end Message -->
<br>

<br>


    <section class="content">

        <!-- Alert Message -->
        
        <div class="row">
            <div class="col-sm-12">
                <div class="column">

                    <a href="{{route('return.product')}}" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> Return Products </a>

                </div>
            </div>
        </div>

        <br>


	<div class="card">
        
        <hr>	
		<div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="{{route('return.purchase.product')}}">
                        @csrf
                        <div class="form-group">
                          <label for="">Enter Purchase Invoice No:</label>
                          <input type="text" name="purchase_invoice_no"  class="form-control" placeholder="Purchase Invoice No.." >
                          <button type="submit" class="btn btn-block btn-primary mt-2">Search</button> 
                        </div>    
                    </form>
                </div>



                <div class="col-md-6">
                    <form method="POST" action="{{route('return.sell.product')}}">
                        @csrf
                        <div class="form-group">
                          <label for="">Enter Sell Invoice No:</label>
                          <input type="text" name="sell_invoice_no"  class="form-control" placeholder="Sell Invoice No.." >
                          <button type="submit" class="btn btn-block btn-primary mt-2">Search</button> 
                        </div>    
                    </form>
                </div>

                    

            </div>
		</div>
    </div>
    
    {!! $component !!}
@endsection

 