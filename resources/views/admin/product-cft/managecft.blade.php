@extends('admin.master')

@section('mainContent')

@section('title')
	Manage Product CFT
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
                    <a href="{{ route('add.product.cft') }}" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> Add Product CFT </a>
                </div>
            </div>
        </div>
    <br>
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> All Products CFT </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                    <tr class="text-center">
                      <th> Description</th>
                      <th> L/W/T</th>
                      <th> CFT</th>
                        <th> Grade</th>
                        
                        <th> Rate</th>
                        {{-- <th> Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                        @forelse ($productCft as $cft)
                    <tr>
                       
                             <td>
                                @foreach ($productGrade as $grade)
                                @if ($grade->id == $cft->grade_id)
                                  {{$cft->length.'x'.$cft->width.'x'.$cft->height.' '.$grade->name.' @'.$grade->price}}
                                @endif 
                             @endforeach
                              
                              </td>
                              @php($totalCft = round((($cft->length * $cft->width * $cft->height) / 1728),4))
                             <td>{{$cft->length.'x'.$cft->width.'x'.$cft->height}}</td>
                             <td>{{$totalCft}}</td>
                             <td>
                               @foreach ($productGrade as $grade)
                                  @if ($grade->id == $cft->grade_id)
                                    {{$grade->name.' @'.$grade->price}}
                                  @endif 
                               @endforeach
                             </td>
                             <td>
                                @foreach ($productGrade as $grade)
                                @if ($grade->id == $cft->grade_id)
                                  @php($totalRate = $totalCft * $grade->price)
                                  {{round($totalRate,2)}}
                                @endif 
                             @endforeach 
                              </td>
                            
                             <td> 
                                 <a class="btn btn-info btn-sm" href="{{ url('/product/cft/edit/'.$cft->id) }}"><i style="font-size: 16px;" class="fa fa-edit" data-toggle="tooltip" title="Update"></i></a>   
                                  <a class="btn btn-danger btn-sm "    href="{{ url('/product/cft/delete/'.$cft ->id) }}" ><i style="font-size: 16px;" class="fa fa-trash" data-toggle="tooltip" title="Delete"></i></a>
                             </td>
           
                    </tr>
                    @empty
                            
                    @endforelse
                </tbody>
             
            </table>

            {{-- {{$productGrade->links()}} --}}
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->

@endsection


<!-- Delete Category ajax code -->
@push('script')

  <!-- tootip text code -->
<script>
        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();   
        });
  </script>
@endpush

