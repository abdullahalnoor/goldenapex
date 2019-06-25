<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\customer_info;
use App\Location;
use App\Product;
use App\invoice;
use App\invoice_details;
use App\Stock;
use App\Supplier;
use App\Godown;
use Illuminate\Support\Facades\Input;
use PDF;

class invoiceController extends Controller
{

    
private function numberTowords(float $number)
{ 
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? 'and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paisa' : '';
    return ($Rupees ? $Rupees.'Tk ' : '') . $paise;
} 




















    public function index() {
        // $day = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->day;
        // dd($day);
        $invoice = invoice::orderBy('id','desc')->paginate(10);
        $customer_info = customer_info::all();
        $totalAmount = invoice::sum('total_amount');
    	return view('admin.invoice.manageInvoice',get_defined_vars());
    }

    public function create() {
        $products = Product::all();
        $locations = Location::all();
        $customer_info = customer_info::all();
       
        $godowns = Godown::all();
        $lastInvoiceID = invoice::orderBy('id', 'DESC')->pluck('sell_invoice_no')->first();
        if(empty( $lastInvoiceID)){
            $newInvoiceID = '1001';
        }else{
            $newInvoiceID = $lastInvoiceID + 1;
        }
    	return view('admin.invoice.invoiceNew', [
            'customer_info' => $customer_info,
            'locations' => $locations,
            'products' => $products,
            'godowns' => $godowns,
            'newInvoiceID' => $newInvoiceID,
        ]);
    }
    public function save(Request $request){
        
        // return $request->all();
        $inputs = Input::except(['_token','customer_id','payment_type','inventory_id','status','invoice_details']);
        
        // check product availability 
        if(empty($request->direct_sell)){
            for($i = 0 ; $i < count($inputs['product_quantity']); $i++){
                if(!empty($request->inventory_id)){
                    $stock = Stock::where('product_id',$request->products_id[$i])->where('inventory_id',$request->inventory_id)->first();
                }elseif(!empty($request->godown_id)){
                    $stock = Stock::where('product_id',$request->products_id[$i])->where('godown_id',$request->godown_id)->first();
                }
                if(empty($stock)){
                    return back()->with('danger','Unavailable Product Quantity..');
                }
                if($request->product_quantity[$i] > $stock->purchase_qty){
                    return back()->with('danger','Unavailable Product Quantity..');
                }        
            }
        }

        
        $lastInvoiceID = invoice::orderBy('id', 'DESC')->pluck('sell_invoice_no')->first();
        if(empty( $lastInvoiceID)){
            $newInvoiceID = '1001';
        }else{
            $newInvoiceID = $lastInvoiceID + 1;
        }

        $invoice = new invoice();

        
        $invoice->date = $request->date;
        $invoice->customer_id = $request->customer_id;
        $invoice->payment_type = $request->payment_type;
        $invoice->status = $request->status;
        $invoice->sell_invoice_no = $newInvoiceID;
        $invoice->invoice_details = $request->invoice_details;
        $invoice->others_bill = $request->others_bill;
        $invoice->others_price = $request->others_price;
        //grand total
        $grand_total = 0;
        if(count($inputs) > 0){
            for($i = 0; $i < count($inputs['product_quantity']); $i++){
                $total_price  = $request->product_quantity[$i] * $request->product_rate[$i] ;
                $grand_total  += $total_price;
            }
        }
       
        //dis one
        $discount_one =$grand_total *  $request->discount_per;
        $discount_one = $discount_one/100;
        $invoice->total_discount = $discount_one;
        $grand_total =  $grand_total - $discount_one;
        //dis two
        $discount_two = $grand_total *  $request->multi_dis;
        $discount_two = $discount_two/100;
        $invoice->total_discount_two = $discount_two ;
        $grand_total = $grand_total - $discount_two ;
        
        $invoice->total_amount = $grand_total + $request->others_price ;
        $invoice->save();

        if(count($inputs) > 0){
            for($i = 0 ; $i < count($inputs['product_quantity']); $i++){
                $invoice_details = new invoice_details();


                if(!empty($request->inventory_id)){
                    $invoice_details->inventory_id = $request->inventory_id;
                }elseif(!empty($request->godown_id)){
                    $invoice_details->godown_id    = $request->godown_id;
                }else{
                    $invoice_details->direct_sell    = $request->direct_sell;
                }

                $invoice_details->invoice_id = $invoice->id;
                $invoice_details->product_id = $request->products_id[$i];
                $invoice_details->quantity = $request->product_quantity[$i];
                $invoice_details->rate = $request->product_rate[$i];
                $total_price = $request->product_quantity[$i] * $request->product_rate[$i];
                
                $discount_one = ($total_price * $request->discount_per)/100;

                $total_price = $total_price - $discount_one; 

                $discount_two = ($total_price *  $request->multi_dis)/100;

                $total_price = $total_price - $discount_two;

                $invoice_details->discount = $discount_one  ;
                $invoice_details->discount_two =  $discount_two;
                $invoice_details->total_price = $total_price;

                $invoice_details->save();
        

                
                if(isset($request->inventory_id)){
                    $stock = Stock::where('product_id',$request->products_id[$i])->where('inventory_id',$request->inventory_id)->first();
                    $stock->purchase_qty -= $request->product_quantity[$i];
                    $stock->sell_qty += $request->product_quantity[$i];
                    $stock->save();
                }elseif(isset($request->godown_id)){
                    $stock = Stock::where('product_id',$request->products_id[$i])->where('godown_id',$request->godown_id)->first();
                    $stock->purchase_qty -= $request->product_quantity[$i];
                    $stock->sell_qty += $request->product_quantity[$i];
                    $stock->save();
                }elseif(isset($request->direct_sell)){
                    $stock = Stock::where('product_id',$request->products_id[$i])->where('direct_sell',$request->direct_sell)->first();
                    if(empty($stock)){
                        $stock = new Stock();
                        $stock->product_id = $request->products_id[$i];
                        $stock->direct_sell = $request->direct_sell;
                        $stock->sell_qty += $request->product_quantity[$i];
                        $stock->save();
                    }else{
                        $stock->sell_qty += $request->product_quantity[$i];
                        $stock->save();
                    }
                }
               
                
            }
        }
        return redirect('/invoice/manage')->with('message','Product Sell Successfully.');

    }
    

    public function edit($id){
        $invoice =  invoice::find($id);
        // return $invoice->total_amount;
        $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->get();
        $customer_info = customer_info::all();
        $products = Product::all();
        $locations = Location::all();
        $godowns = Godown::all();
        $lastInvoiceID = invoice::orderBy('id', 'DESC')->pluck('sell_invoice_no')->first();
        $inventoryId = invoice_details::where('invoice_id',$invoice->id)->first(['godown_id','inventory_id','direct_sell']);
        // return $inventoryId->direct_sell;
        
        return view('admin.invoice.editInvoice',get_defined_vars());
    }

    public function update(Request $request){
        
        // return $request->all();

        // return $request->all();
        $inputs = Input::except(['_token','customer_id','payment_type','inventory_id','status','invoice_details']);
        


        $invoice =  invoice::find($request->invoice_detail_id);
        // check product are available and update stock table
        
            for($i = 0 ; $i < count($inputs['product_quantity']); $i++){

                $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('product_id',$request->product_id[$i])->first();
               
                if(empty($request->direct_sell)){
              
                    if(!empty($request->inventory_id)){
                        
                        $stock = Stock::where('product_id',$invoice_details->product_id)->where('inventory_id',$request->inventory_id)->first();
                        if($request->product_quantity[$i] > ($stock->purchase_qty + $invoice_details->quantity) ){
                            return back()->with('danger','Unavailable Product Quantity..');
                        }
                    }elseif(!empty($request->godown_id)){
                        $stock = Stock::where('product_id',$invoice_details->product_id)->where('godown_id',$request->godown_id)->first();
                        if($request->product_quantity[$i] > ($stock->purchase_qty + $invoice_details->quantity) ){
                            return back()->with('danger','Unavailable Product Quantity..');
                        }
                    }
                    $stock->sell_qty -= $invoice_details->quantity;
                    $stock->purchase_qty += $invoice_details->quantity;
                    $stock->save();
                    $stock->sell_qty += $request->product_quantity[$i];
                    $stock->purchase_qty -= $request->product_quantity[$i];
                    $stock->save();
                }elseif(!empty($request->direct_sell)){
                    $stock = Stock::where('product_id',$invoice_details->product_id)->where('direct_sell',$request->direct_sell)->first();
                    $stock->sell_qty -= $invoice_details->quantity;
                    $stock->sell_qty += $request->product_quantity[$i];
                    $stock->save();
                }
            }
        
        


        $invoice->date = $request->date;
        $invoice->customer_id = $request->customer_id;
        $invoice->payment_type = $request->payment_type;
        $invoice->status = $request->status;
        $invoice->others_bill = $request->others_bill;
        $invoice->others_price = $request->others_price;
        $invoice->invoice_details = $request->invoice_details;
        //grand total
        $grand_total = 0;
        if(count($request->product_quantity) > 0){
            for($i = 0; $i < count($request->product_quantity); $i++){
                $total_price  = $request->product_quantity[$i] * $request->product_rate[$i] ;
                $grand_total  += $total_price;
            }
        }
       
        //dis one
        // return $grand_total;
        $discount_one =($grand_total *  $request->discount_per)/100;
        $invoice->total_discount = $discount_one;
        $grand_total =  $grand_total - $discount_one;
        //dis two
        $discount_two = ($grand_total *  $request->multi_dis)/100;
        $invoice->total_discount_two = $discount_two ;
        $grand_total = $grand_total - $discount_two ;
        
        $invoice->total_amount = $grand_total + $request->others_price;
        $invoice->save();

        if(count($inputs) > 0){
            for($i = 0 ; $i < count($inputs['product_quantity']); $i++){
                $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('product_id',$request->product_id[$i])->first();
            


                $invoice_details->quantity = $request->product_quantity[$i];
                $invoice_details->rate = $request->product_rate[$i];
                $total_price = $request->product_quantity[$i] * $request->product_rate[$i];
                
                $discount_one = ($total_price * $request->discount_per)/100;

                $total_price = $total_price - $discount_one; 

                $discount_two = ($total_price *  $request->multi_dis)/100;

                $total_price = $total_price - $discount_two;

                $invoice_details->discount = $discount_one  ;
                $invoice_details->discount_two =  $discount_two ;

                $invoice_details->total_price = $total_price;

                $invoice_details->save();
                
            }
        }
        return redirect('/invoice/manage')->with('message','Product Sell Update Successfully.');
    }

    public function delete($id){
       
        $invoice =  invoice::find($id);
        $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->get();
        foreach($invoice_details as $item){
              
                if(!empty($item->inventory_id) || count($item->inventory_id) >= 0){
                    $stock = Stock::where('inventory_id',$item->inventory_id)->where('product_id',$item->product_id)->first();
                    $stock->purchase_qty += $item->quantity;
                    $stock->sell_qty -= $item->quantity;
                    $stock->save();
                    $item->delete();
                }elseif(!empty($item->godown_id) || count($item->godown_id) >= 0){
                    $stock = Stock::where('godown_id',$item->godown_id)->where('product_id',$item->product_id)->first();
                    $stock->purchase_qty += $item->quantity;
                    $stock->sell_qty -= $item->quantity;
                    $stock->save();
                    $item->delete();
                }elseif(!empty($item->direct_sell) || count($item->direct_sell) >= 0){
                    $stock = Stock::where('direct_sell',$item->direct_sell)->where('product_id',$item->product_id)->first();
                    $stock->sell_qty -= $item->quantity;
                    $stock->save();
                    $item->delete();
                }
            
        }
        $invoice->delete();       
                
        return redirect('/invoice/manage')->with('message','Product Sell Information Successfully.');
    }

    public function invoiceProductPDF($id,$type){


        $invoice =  invoice::find($id);
        // return $invoice->total_amount;
        $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->get();
        $customer_info = customer_info::where('id',$invoice->customer_id)->first();
        $products = Product::all();
        // $locations = Location::all();
        // $godowns = Godown::all();
        // $lastInvoiceID = invoice::orderBy('id', 'DESC')->pluck('sell_invoice_no')->first();
        // $inventoryId = invoice_details::where('invoice_id',$invoice->id)->first(['godown_id','inventory_id','direct_sell']);
        // return $inventoryId->direct_sell;

        $pdf = PDF::loadView('admin.invoice.pdf',get_defined_vars())->setPaper('a4', 'vertical');
        $challan = PDF::loadView('admin.invoice.challan',get_defined_vars())->setPaper('a4', 'vertical');
        $tot = (float) $invoice->total_amount;
        return $this->numberTowords($tot);
        
        if($type == 'invoice'){
            return $pdf->stream($customer_info->customer_name.'_'.'Sell_Invoice_No'.'_'.$invoice->sell_invoice_no.'.pdf');
        }elseif($type == 'challan'){
            return $challan->stream($customer_info->customer_name.'_'.'Challan No'.'_'.$invoice->sell_invoice_no.'.pdf');
        }
    }




}
