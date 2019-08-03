<?php

namespace App\Http\Controllers;

use App\customer_info;
use Illuminate\Http\Request;
use App\CustomerPayment;
use App\invoice;
use App\invoice_details;
use App\product;
use DB;
use Illuminate\Support\Arr;

class customerController extends Controller
{
    public function index(){
        
    	return view('admin.customer.addcustomer');
    }

    public function save(Request $request){
    	$customeradd = new customer_info();
    	$customeradd->customer_name = $request->customer_name;
    	$customeradd->customer_address = $request->address;
    	$customeradd->customer_mobile = $request->mobile;
    	$customeradd->customer_email = $request->email;
    	$customeradd->save();

    	return redirect('/customer/manage')->with('message','Customer Information added Successfully.');
    }

    public function manage(){
    	$customer_info = customer_info::orderBy('id','DESC')->paginate(10);
    	return view('admin.customer.managecustomer', get_defined_vars());
    }

    public function edit($id){
        $customer_info = customer_info::where('id',$id)->first();

        // return $customer_info;

        return view('admin.customer.editcustomer', get_defined_vars());
    }

    public function update(Request $request){
        $customer_info = customer_info::find($request->id);
        $customer_info->customer_name = $request->input('customer_name');
        $customer_info->customer_address = $request->input('address');
        $customer_info->customer_mobile = $request->input('mobile');
        $customer_info->customer_email = $request->input('email');
        $customer_info->status = $request->input('status') == '' ? 1 : $request->input('status');
        $customer_info->save();

        return redirect('/customer/manage')->with('message','Customer Information update Successfully.');

    }

    public function delete($id){
        $customer_info = customer_info::find($id);
        $customer_info->delete();

        return redirect('/Customer/manage')->with('message','Customer Information Deleted Successfully.');
    }

    public function managecredit(){
        $customer_info = customer_info::all();
        return view('admin.customer.creditcustomer', get_defined_vars());
    }

    public function managepaid(){
        $customer_info = customer_info::all();
        return view('admin.customer.paidcustomer', get_defined_vars());
    }


    public function addCustomerPayment(){
        $customer_info = customer_info::all();

       

        return view('admin.customer.customer-payment', get_defined_vars());
    }


    public function fetchCustomerpaymentDetail($id){
        $customer_detail = customer_info::find($id);
        $customerPayment = CustomerPayment::where('customer_id',$id)->get();
        $paidAmount = $customerPayment->whereIn('type',[1,2])->sum('payment_total');
        $invoice = $customerPayment->where('type',0)->sum('payment_total');
        $balance =  $invoice - $paidAmount ;
        // return $balance;
        $data = [ 
            'customer'=> $customer_detail,
            'paidAmount'=> $paidAmount,
            'balance'=> $balance,
        ] ;
        return $data;
    }

    public function saveCustomerPayment(Request $request){

        // return $request->all();

    
        $customerPayment = new CustomerPayment();

        
        $customerPayment->payment_total = $request->receive_amount;
        $customerPayment->customer_id =  $request->customer_id; 
        $customerPayment->date =   $request->date;
        $customerPayment->type =   1; // 1 mean credit payment
        $customerPayment->save();
        return back();
    }


    public function customerLedger(){
        $customer_info = customer_info::all();
        $view = '';
        $customerPayment = '';
        $current_customer_info = '';
        return view('admin.customer.customer-ledger', get_defined_vars());
    }

    public function customerLedgerDetail(Request $request){
        // return $request->all();
        $customer_info = customer_info::all();
        $current_customer_info = customer_info::find($request->customer_id);
        $customerPayment = CustomerPayment::where('customer_id',$request->customer_id)->orderBy('id','asc')->get();
        $totalPaidAmount = $customerPayment->whereIn('type',[1,2])->sum('payment_total');
        // return $totalPaidAmount;
        $totalInvoiceAmount = $customerPayment->whereIn('type',0)->sum('payment_total');

        // $totalInvoiceAmount = invoice::where('customer_id',$request->customer_id)->get()->sum('total_amount');
        // return $invoice;
        // $invoice = invoice::where('customer_id',$customerPayment->customer_id)->first();
        // DB::table('users')
        // ->join('contacts', function ($join) {
        //     $join->on('users.id', '=', 'contacts.user_id')
        //          ->where('contacts.user_id', '>', 5);
        // })
        // ->get();

        $customerLedger = \DB::table('customer_payments')
        ->join('invoices', function ($join) {
            $join->on('customer_payments.customer_id', '=', 'invoices.customer_id');
        })
        ->get();

        $data = [

        ];
     
       
        return view('admin.customer.customer-ledger', get_defined_vars());
       
    }


    public function viewPaidCustomer(){
        $customer_info = customer_info::get();
        $customerPayment = CustomerPayment::get();
        // $customerPayment = CustomerPayment::where('customer_id',$request->customer_id)->orderBy('id','asc')->get();
        // $totalPaidAmount = $customerPayment->whereIn('type',[1,2])->sum('payment_total');
        // // return $totalPaidAmount;
        // $totalInvoiceAmount = invoice::where('customer_id',$request->customer_id)->get()->sum('total_amount');
        return view('admin.customer.paid-customer',get_defined_vars());
    }


    public function viewDueCustomer(){
        $customer_info = customer_info::get();
        $customerPayment = CustomerPayment::get();
     return view('admin.customer.due-customer',get_defined_vars());
    }


    public function manageCustomerPayment(){
        $customer_info = customer_info::all();
        $customerPayment = CustomerPayment::whereIn('type',[1,2])->orderBy('id','desc')->paginate(10);
     return view('admin.customer.manage-payment',get_defined_vars());

    }


    public function saleReportProductWise(){
        // invoice
        // invoice_details
        $collection = '';
     return view('admin.report.product-wise-sales',get_defined_vars());
    }

    public function viewSaleReportProductWise(Request $request){

    isset($request->start_date) ? $start_date = date('Y-m-d',strtotime($request->start_date)) :  $start_date = date('Y-m-d');
    isset($request->end_date) ? $end_date = date('Y-m-d',strtotime($request->end_date)) :  $end_date = date('Y-m-d');

        $invoicesId = invoice::whereBetween('date',[$start_date,$end_date])->pluck('id');
      
        $collection = [];
        $product = product::all();

        foreach($product as $key => $value){
            $collection[$key]['name'] = product::find($value->id)->product_name;
            $collection[$key]['quantity'] = invoice_details::whereIn('invoice_id',$invoicesId)->where('product_id',$value->id)->sum('quantity');
            $collection[$key]['total_price'] = invoice_details::whereIn('invoice_id',$invoicesId)->where('product_id',$value->id)->sum('total_price');
        }

        foreach($product as $key => $value){
            $collection[$key] = [
                'name' => product::find($value->id)->product_name,
                'quantity' => invoice_details::whereIn('invoice_id',$invoicesId)->where('product_id',$value->id)->sum('quantity'),
                'total_price' => invoice_details::whereIn('invoice_id',$invoicesId)->where('product_id',$value->id)->sum('total_price'),
    
            ];
          }

        
        // return $collection;

      

        $invoicesId = \DB::table('invoices')
        ->whereBetween('date',[$start_date,$end_date])
        // ->select('id')
        ->get()
        ->pluck('id');
 

    $invoiceDetail = \DB::table('invoice_details')
                        ->select(\DB::raw('SUM(quantity) as quantity'),\DB::raw('SUM(total_price) as total_price'), DB::raw('product_id as product_id'))
                        // ->get()
                        ->whereIn('invoice_id',$invoicesId)
                        ->groupBy('product_id')
                        // ->select(\DB::raw('SUM(quantity) as quantity'),\DB::raw('SUM(total_price) as total_price'))

                        ->get();

                       

         
                        // return $invoiceDetail;

                        $invoiceDetail = DB::table("invoice_details")
                        ->whereIn('invoice_id',$invoicesId)
                        ->groupBy(DB::raw("product_id"))
                        ->get(
                            array(
                                DB::raw('SUM(quantity) as quantity'),
                                DB::raw('SUM(total_price) as total_price'),
                                DB::raw('product_id as product_id'),
                              )
                        )->toArray();


                   $newCollection = [];     


                   for($i = 0; $i < count($invoiceDetail) ; $i++){
                    //    return $invoiceDetail[$i]->quantity;
                    $newCollection[$i]['name'] = product::find($invoiceDetail[$i]->product_id)->product_name;
                    $newCollection[$i]['quantity'] = $invoiceDetail[$i]->quantity;
                    $newCollection[$i]['total_price'] = $invoiceDetail[$i]->total_price;
                   }     
  
                    
                    return $newCollection;
   

      
        return view('admin.report.product-wise-sales',get_defined_vars());

    }





}
