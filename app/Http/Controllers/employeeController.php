<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\employee;
use Auth;
use App\customer_info;
use App\moneycollection;
use App\product_order;
use App\order_details;
class employeeController extends Controller
{

    public function dashboardindex(){
        return view('employee.home.homeContent');
    }

    
    public function index(){
    	return view('admin.employee.addemployee');
    }

    public function save(Request $request){
    	$employeeadd = new employee();
    	$employeeadd->name = $request->Employee_name;
    	$employeeadd->email = $request->email;
    	$employeeadd->phone = $request->phone;
    	$employeeadd->address = $request->address;
    	$employeeadd->balance = $request->previous_balance;
    	$employeeadd->designation = $request->designation;
    	$employeeadd->password = $request->password;
    	$employeeadd->save();

    	return redirect('/employee/manage')->with('message','Employeeadd Information added Successfully.');
    }

    public function manage(){
    	$employees = employee::all();
    	return view('admin.employee.manageemployee', get_defined_vars());
    }

    public function edit($id){
        $employees = employee::where('id',$id)->first();

        return view('admin.employee.employeeedit', get_defined_vars());
    }

    public function update(Request $request){
        $employees = employee::find($request->id);
        $employees->name = $request->input('name');
        $employees->email = $request->input('address');
        $employees->phone = $request->input('phone');
        $employees->address = $request->input('address');
        $employees->designation = $request->input('designation');
        $employees->status = $request->input('status');
        $employees->save();

        return redirect('/employee/manage')->with('message','Employee Information update Successfully.');

    }

    public function delete($id){
        $employees = employee::find($id);
        $employees->delete();

        return redirect('/employee/manage')->with('message','Employee Information Deleted Successfully.');
    }

    public function collection(){
        $customers = customer_info::all();
        return view('employee.collection.collectionmoney', get_defined_vars());
    }

    public function collectionsave(Request $request){
        $collectionadd = new moneycollection();
        $collectionadd->date = $request->date;
        $collectionadd->customer_id = $request->customer_id;
        $collectionadd->employee_id = Auth::guard('employee')->user()->id;
        $collectionadd->due = $request->due;
        $collectionadd->description = $request->descrpition;
        $supplier = customer_info::find($request->customer_id);
        $supplier->customer_mobile;
        $collectionadd->save();

        return redirect()->back()->with('message','Money Collection added Successfully.');
    }

    public function order(){
        $customers = customer_info::all();

        $lastInvoiceID = product_order::orderBy('id', 'DESC')->pluck('order_no')->first();
        if(empty( $lastInvoiceID)){
            $newInvoiceID = '1001';
        }else{
            $newInvoiceID = $lastInvoiceID + 1;
        }
        return view('employee.order.order', [
            'customers' => $customers,
            'newInvoiceID' => $newInvoiceID,
        ]);
    }

    public function ordersave(Request $request){

       $lastInvoiceID = product_order::orderBy('id', 'DESC')->pluck('order_no')->first();
        if(empty( $lastInvoiceID)){
            $newInvoiceID = '1001';
        }else{
            $newInvoiceID = $lastInvoiceID + 1;
        }
        
        $product_order = new product_order();
        $product_order->order_no = $newInvoiceID;
        $product_order->customer_id = $request->customer_id;
        $product_order->employee_id = Auth::guard('employee')->user()->id;
        $product_order->date = $request->date;
        $product_order->grand_total = $request->grand_total;
        $product_order->save();

        if(count($request->item_type) > 0){
            for($i = 0; $i < count($request->item_type); $i++){
                $detail = new order_details();
                $detail->order_id = $product_order->id;


                $detail->item_type = $request->item_type[$i];
                $detail->item_name = $request->item_name[$i];
                $detail->qty = $request->product_quantity[$i];
                $detail->rate = $request->product_rate[$i];
                $total_price =  $request->product_quantity[$i] * $request->product_rate[$i];
                $detail->total = $total_price;
                $detail->meterial = $request->product_mate[$i];
                $detail->save();
            } 
        }

        return redirect()->back()->with('message','Product Order Successfully.');

    }
}
