@extends('admin.master')

@section('title')
	Order Report
@endsection

@section('mainContent')

	<section>
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-heading">
                        
                    </div>
                    <div class="card-body">
						<div class="card-title">
                            <h4>Order Report</h4>
                            <hr>
                        </div>
                            <form action="{{route('view-marketing.order')}}" class="form-inline" method="POST" accept-charset="utf-8">
                                @csrf
                        <div class="form-group">
                             <label for="employee_id">Employee Name<i class="text-danger">*</i></label>
                            <select class="form-control  ml-2 " name="employee_id">
                                <option value="">Select One</option>
								@foreach ($employee as $employee)
									<option value="{{ $employee->id }}">{{ $employee->name }}</option>
								@endforeach
                            </select>
                        </div>
                        <samp style="width: 10px"></samp>
                        <div class="form-group">
                            <label class="" for="from_date">Start Date <i class="text-danger">*</i> </label>
                            	<input  type="date" name="from_date" class="form-control  ml-2 datepicker" id="from_date" placeholder="Start Date">
                        </div> 
						<samp style="width: 10px"></samp>
                        <div class="form-group">
                            <label class="" for="to_date">End Date <i class="text-danger">*</i> </label>
                            <input type="date" name="to_date" class="form-control  ml-2 datepicker" id="to_date" placeholder="End Date">
                        </div>  
						<samp style="width: 10px"></samp>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <!-- <samp style="width: 10px"></samp>
                        <a  class="btn btn-info" href="#" onclick="printDiv('purchase_div')">Print</a> -->
                        </form>                
                        
                    </div>
                    
                </div>
            </div>
        </div>
		
        <div class="row">
            <div class="col-sm-12" id="printArea">
                <div class="card card-bd lobidrag">
                    <div class="card-heading">
                    </div>
                    <div class="card-body">
                    	<div class="card-title">
                            <h4>Customer Sales Report </h4>
                        </div>
                        <div class="row"><div class="col-sm-10">
                             <div class="col-sm-6"> <label class="" for="phone">Phone :</label> <label class="" for="phone">01829873973</label></div>
                             <div class="col-sm-6"><label class="" for="name">Name :</label> <label class="" for="name">Md. Maksudur Rahman</label></div>
                             <div class="col-sm-12"><label class="" for="address">Address :</label> <label class="" for="address">Shajahanpur, Bogura-5800</label></div>
                            
                             <div class="col-sm-6"><label class="" for="from_date">From Date :</label> <label class="" for="from_date">2019-06-01</label></div>
                             <div class="col-sm-6"><label class="" for="to_date">To Date :</label> <label class="" for="to_date">2019-06-18</label></div>

                         </div>
                        </div>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
             <th>Date</th>
             <th>Item</th>   
             <th>Quantity</th>   
             <th>Rate</th>   
             <th>Total</th>      
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2019-06-03</td>
                <td>CST TYR 10.00-R20-CR969</td>
                <td class="text-right">2</td>
                <td class="text-right">28100</td>
                <td align="right">56,200.00</td>
            </tr>
                    <tr>
                <td>2019-06-13</td>
                <td>CST TYR 10.00-R20-CR969</td>
                <td class="text-right">2</td>
                <td class="text-right">281000</td>
                                          <td align="right">562,000.00</td>
            </tr>
                    <tr>
                <td>2019-06-16</td>
                <td>CST TYR 10.00-R20-CR969</td>
                <td class="text-right">2</td>
                <td class="text-right">28100</td>
                                          <td align="right">56,200.00</td>
            </tr>
                    <tr>
                <td>2019-06-16</td>
                <td>CST TYR 10.00-R20-CR969</td>
                <td class="text-right">2</td>
                <td class="text-right">28100</td>
                                          <td align="right">56,200.00</td>
            </tr>
                        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right"><b>Total</b></td><td class="text-right">8.00</td><td class="text-right"></td><td class="text-right">730,600.00</td>
            </tr>
        </tfoot>
    </table>
</div>
                                 
                
                        
                    </div>
                    
                </div>
            </div>
        </div>

    </section>
</div>
<!-- Add new customer sales end -->

    </section>
<!-- Add new customer statement end -->




@endsection