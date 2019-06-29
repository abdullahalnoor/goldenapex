<?php

namespace App\Http\Controllers;
use App\employee;
use App\product_order;
use Illuminate\Http\Request;

class marketingReportController extends Controller
{
    public function order(){
    	$employee = employee::all();
    	return view('admin.report.order_report', get_defined_vars());
    }


    public function viewMarketingOrder(Request $request){
        // return $request->all();
        $employee = employee::findOrFail($request->employee_id);
        // return $employee->created_at;

        // $product_order = product_order::where();
         
        $from_date = date("Y-m-d", strtotime($request->from_date));
        $to_date = date("Y-m-d", strtotime($request->to_date));
        // return $from_date;
        $product_order =  \DB::table('product_orders')
            ->where('employee_id',$request->employee_id)
   			->whereBetween('date', [$from_date, $to_date])
   			->get();
        return $product_order;
        // return $request->from_date;
    }

    public function due(){
    	$employee = employee::all();
    	return view('admin.report.due_colection', get_defined_vars());
    }
}
