<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\product;
use App\Location;
use App\product_purchase;
use App\product_purchase_details;
use App\Stock;
use App\Godown;
use App\PurchaseReturn;
use App\PurchaseReturnDetail;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
use PDF;
use App\invoice;
use App\invoice_details;
use App\customer_info;
use App\SellReturn;
use App\SellReturnDetail;
use App\ProductGrade;
use App\ProductCft;
// use Request;


class ProductReturnController extends Controller
{
    public function returnProduct(){
        $component = '';
        return view('admin.return.product-return',get_defined_vars());
    }

    public function returnPurchaseProduct(Request $request,$invoice=null){
        $product_purchase;
        if ($request->isMethod('post')){
            $product_purchase = product_purchase::where('purchase_invoice_no',$request->purchase_invoice_no)->first();

        }elseif($request->isMethod('get')){
            if($invoice != null){
                $product_purchase = product_purchase::where('purchase_invoice_no',$invoice)->first();
            }
        }
        if(empty($product_purchase)){
            return redirect()->route('return.product')->with('danger','Invoice Not Found..');
        }

        $suppliers = Supplier::all();
        $products = product::all();
        $locations = Location::all();
        $godowns = Godown::all();
        // return $request->purchase_invoice_no;
       
        
        // return $product_purchase->id;
        // $inventoryId = product_purchase_details::where('purchase_id',$product_purchase->id)->get(['godown_id','inventory_id'])->unique();
        $inventoryId = product_purchase_details::where('purchase_id',$product_purchase->id)->first(['godown_id','inventory_id']);
       
       
        $location_id = 0;
        $godown_id  = 0;


        if(!empty($inventoryId->inventory_id) || $inventoryId->inventory_id != ''){
            $location_id = Location::find($inventoryId->inventory_id);
            $location_id = $location_id->id;
        }elseif(!empty($inventoryId->godown_id) || $inventoryId->godown_id != ''){
            $godown_id = Godown::find($inventoryId->godown_id);
            $godown_id  = $godown_id->id;
        }

        
        
        // return $inventory_id;
        // $availableProducts;
        if($inventoryId->inventory_id != ''){
            // return 0;
            $availableProducts = Stock::where('inventory_id','>=','0')->get()->groupBy('inventory_id');
        }else{
            // return 1;
            $availableProducts = Stock::where('godown_id','>=','0')->get()->groupBy('godown_id');
        }

        // return $availableProducts[0]['purchase_qty'];


        // return $inventoryId;

        

        $product_purchase_details = product_purchase_details::where('purchase_id',$product_purchase->id)->get();
        
        $component = view('admin.return.purchase-return',get_defined_vars());
        
        return view('admin.return.product-return',[
            
            'component' => $component,
            
        ]);
    }

    public function submitrReturnPurchaseProduct(Request $request){
            // return $request->all();

            $product_purchase = product_purchase::where('id',$request->purchase_id)->first();

            for ($i=0; $i < count($request->purchase_return_quantity); $i++) { 
                if(empty($request->purchase_return_quantity[$i]) || $request->purchase_return_quantity[$i] != ' '){
                    $product_purchase_details = product_purchase_details::where('purchase_id',$product_purchase->id)->where('product_id',$request->purchase_product_id[$i])->first();

                    if($request->purchase_return_quantity[$i]  > $product_purchase_details->quantity  ){
                        return redirect()->route('return.purchase.product',$product_purchase->purchase_invoice_no)->with('danger','Return Quantity should be less than Purchase Quantity..');
                        // $product_purchas->purchase_invoice_no return.purchase.product
                    }
                }
            }


           
            // return $product_purchase->supplier_id;
            $purchaseReturn = new PurchaseReturn();

            $purchaseReturn->purchase_id = $product_purchase->id;
            $purchaseReturn->supplier_id =$product_purchase->supplier_id;
            $purchaseReturn->return_date = date("Y/m/d");
            $purchaseReturn->grand_total = $request->purchase_grand_total_price;
            $purchaseReturn->save();

            $totalDiscountPrice = 0;
           
            for ($i=0; $i < count($request->purchase_return_quantity); $i++) { 
                if($request->purchase_return_quantity[$i] != null || !empty($request->purchase_return_quantity[$i]) ){
                    


                    $purchaseReturnDetail = new PurchaseReturnDetail();
                    $purchaseReturnDetail->purchase_return_id = $purchaseReturn ->id;


                    $purchaseReturnDetail->location_id = $request->location_id == 0 ? 0 : $request->location_id;
                    $purchaseReturnDetail->godown_id = $request->godown_id == 0 ? 0 : $request->godown_id;

                    $purchaseReturnDetail->product_id = $request->purchase_product_id[$i];
                    $purchaseReturnDetail->purchase_return_qty = $request->purchase_return_quantity[$i];


                    

                    //dis percentage
                    $product_purchase_details = product_purchase_details::where('purchase_id',$product_purchase->id)->where('product_id',$request->purchase_product_id[$i])->first();
                //    return $product_purchase_details;
                    $total =  $product_purchase_details->discount +  $product_purchase_details->total_amount;
                    $discount = $product_purchase_details->discount /$total ;
                    $discount_per = $discount * 100;

                     // price dis
                     $price =  $request->purchase_total_price[$i] / $request->purchase_return_quantity[$i] ;
                     $discount =  $price * $discount_per;
                     $priceDiscount = $discount/100;


                    
                    
                     $purchaseReturnDetail->price = $price -$priceDiscount;

                    // total dis
                    $total_price =   $request->purchase_total_price[$i];
                    $discount =  $total_price * $discount_per;
                    $discount = $discount/100;

                    // total discount sum 
                    $totalDiscountPrice += $discount;

                    $purchaseReturnDetail->total = $total_price -$discount;

                    $purchaseReturnDetail->save();

                    $product_purchase_details->total_amount -= $purchaseReturnDetail->total;
                    $product_purchase_details->quantity -=  $request->purchase_return_quantity[$i];
                    // $product_purchase_details->total_amount -=  $price -$priceDiscount;
                    $product_purchase_details->discount -=  $discount;
                    $product_purchase_details->save();

                  
                    if($request->location_id != 0){
                        $stock = Stock::where('product_id',$request->purchase_product_id[$i])->where('inventory_id',$request->location_id)->first();
                        $stock->purchase_qty -= $request->purchase_return_quantity[$i];
                    }elseif($request->godown_id != 0){
                        $stock = Stock::where('product_id',$request->purchase_product_id[$i])->where('godown_id',$request->godown_id)->first();
                        $stock->purchase_qty -= $request->purchase_return_quantity[$i];
                    }

                    // return $stock; godown_id
                    $stock->save();

                }
               
            }
            $product_purchase->grand_total_amount -=  $request->purchase_grand_total_price;
            $product_purchase->total_discount -= $totalDiscountPrice;
             $product_purchase->save();
           return redirect()->route('return.product')->with('succes','Return Successfully..');  

    }


    public function returnSellProduct(Request $request,$invoice=null){
        $invoice;
        if ($request->isMethod('post')){
            $invoice =  invoice::where('sell_invoice_no',$request->sell_invoice_no)->first();
        }elseif($request->isMethod('get')){
            if($invoice != null){
                $invoice =  invoice::where('sell_invoice_no',$invoice)->first();
            }
        }
        if(empty($invoice)){
            return redirect()->route('return.product')->with('danger','Invoice Not Found..');
        }
        $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->get();
        $customer_info = customer_info::all();
        $products = Product::all();
        $locations = Location::all();
        $godowns = Godown::all();
        $lastInvoiceID = invoice::orderBy('id', 'DESC')->pluck('sell_invoice_no')->first();
        $inventoryId = invoice_details::where('invoice_id',$invoice->id)->first(['godown_id','inventory_id','direct_sell']);
        // return $inventoryId->direct_sell;
        // $product_purchase_details = product_purchase_details::where('purchase_id',$product_purchase->id)->get();
        $productCft =  ProductCft::all();
        $productGrade = ProductGrade::all();
        $component = view('admin.return.sell-return',get_defined_vars());
        
        return view('admin.return.product-return',[
            
            'component' => $component,
            
        ]);


        
    }


    public function submitReturnSellProduct(Request $request){

       
            // return $request->all();
            $invoice =  invoice::where('id',$request->invoice_id)->first();
            

            for ($i=0; $i < count($request->return_sell_quantity); $i++) { 

                if($request->return_sell_quantity[$i] != null || !empty($request->return_sell_quantity[$i]) ){
                    $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('godown_id',$request->godown_id)->where('product_id',$request->product_id[$i])->first();

                    if($request->return_sell_quantity[$i]  > $invoice_details->quantity  ){
                        return redirect()->route('return.sell.product',$invoice->sell_invoice_no)->with('danger','Return Quantity should be less than Sold Quantity..');
                        // $product_purchas->purchase_invoice_no return.purchase.product
                    }
                }
            }




           $sellReturn =  new  SellReturn();

          $sellReturn->sell_id = $invoice->id;
          $sellReturn->customer_id = $invoice->customer_id;
          $sellReturn->return_date = date("Y/m/d");
          $sellReturn->grand_total = $request->sell_grand_total_price;
          $sellReturn->save();

          $invoice->total_amount -= $request->sell_grand_total_price;
          $invoice->total_discount -= $request->discount_total ;
          $invoice->total_discount_two -= $request->multi_dis_total;
          $invoice->save();

          $invoice_details;
          if(isset($request->inventory_id)){
            $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('inventory_id',$request->inventory_id)->get();
         
        }elseif(isset($request->godown_id)){
            $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('godown_id',$request->godown_id)->get();

        }elseif(isset($request->direct_sell)){
            $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('direct_sell',$request->direct_sell)->get();

        }
          
          for ($i=0; $i < count($request->return_sell_quantity); $i++) { 

            if($request->return_sell_quantity[$i] != null || !empty($request->return_sell_quantity[$i]) ){
                $sellReturnDetail = new SellReturnDetail();
                $sellReturnDetail->sell_return_id =  $sellReturn->id;
                $sellReturnDetail->product_id =  $request->product_id[$i];
                $sellReturnDetail->sell_return_qty =  $request->return_sell_quantity[$i];

                if(isset($request->inventory_id)){
                    $sellReturnDetail->location_id =  $request->inventory_id;
                }elseif(isset($request->godown_id)){
                    $sellReturnDetail->godown_id =  $request->godown_id;
                }elseif(isset($request->direct_sell)){
                    $sellReturnDetail->direct_sell =  $request->direct_sell;
                }


                // price dis
              
                $total_price =   $request->sell_total_price[$i] / $request->return_sell_quantity[$i];
                $discount_one =  $total_price * $request->discount_per;
                $discount_one = $discount_one/100;

                $total_price = $total_price - $discount_one;

                $discount_two =  $total_price *  $request->multi_dis;
                $discount_two = $discount_two/100;

                $total_price = $total_price - $discount_two;

                $sellReturnDetail->price = $total_price;

                 // total dis

                $total_price =   $request->sell_total_price[$i] ;
                $discount_one =  $total_price * $request->discount_per;
                $discount_one = $discount_one/100;

                $total_price = $total_price - $discount_one;

                $discount_two =  $total_price *  $request->multi_dis;
                $discount_two = $discount_two/100;

                $total_price = $total_price - $discount_two;

                $sellReturnDetail->total = $total_price;
                $sellReturnDetail->save();



                // $sellReturnDetail->direct_sell =  $request->direct_sell;
                //$request->sell_total_price[$i] / $request->return_sell_quantity[$i];

                // if(isset($request->inventory_id)){
                //     $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('inventory_id',$request->inventory_id)->where('product_id',$request->product_id[$i])->first();
                 
                // }elseif(isset($request->godown_id)){
                //     $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('godown_id',$request->godown_id)->where('product_id',$request->product_id[$i])->first();

                // }elseif(isset($request->direct_sell)){
                //     $invoice_details =  invoice_details::where('invoice_id',$invoice->id)->where('direct_sell',$request->direct_sell)->where('product_id',$request->product_id[$i])->first();

                // }
                    $invoice_details[$i]->quantity -= $request->return_sell_quantity[$i];
                    $invoice_details[$i]->discount -= $discount_one;
                    $invoice_details[$i]->discount_two -= $discount_two;
                    $invoice_details[$i]->total_price -= $total_price;
                    $invoice_details[$i]->save();
               


                // stock manage
                if(isset($request->inventory_id)){
                    $stock = Stock::where('product_id',$request->product_id[$i])->where('inventory_id',$request->inventory_id)->first();
                    $stock->purchase_qty += $request->return_sell_quantity[$i];
                    $stock->sell_qty -= $request->return_sell_quantity[$i];
                }elseif(isset($request->godown_id)){
                    $stock = Stock::where('product_id',$request->product_id[$i])->where('godown_id',$request->godown_id)->first();
                    $stock->purchase_qty += $request->return_sell_quantity[$i];
                    $stock->sell_qty -= $request->return_sell_quantity[$i];
                }elseif(isset($request->direct_sell)){
                    $stock = Stock::where('product_id',$request->product_id[$i])->where('direct_sell',$request->direct_sell)->first();
                    $stock->sell_qty -= $request->return_sell_quantity[$i];
                }

                // return $stock; godown_id
                $stock->save();



            }

            
         }

           
         return redirect()->route('return.product')->with('succes','Return Successfully..');  
    }

































}
