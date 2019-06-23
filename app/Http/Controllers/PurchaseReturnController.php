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

class PurchaseReturnController extends Controller
{
    public function returnProduct(){
        $component = '';
        return view('admin.return.product-return',get_defined_vars());
    }
    public function returnPurchaseProduct(Request $request){
        $suppliers = Supplier::all();
        $products = product::all();
        $locations = Location::all();
        $godowns = Godown::all();
        // return $request->purchase_invoice_no;
        $product_purchase = product_purchase::where('purchase_invoice_no',$request->purchase_invoice_no)->first();
        
        
        // return $product_purchase->id;
        $inventoryId = product_purchase_details::where('purchase_id',$product_purchase->id)->first(['inventory_id']);
        //$inventoryId = product_purchase_details::where('purchase_id',$product_purchase->id)->get(['godown_id','inventory_id'])->unique();
        $inventory_id = Location::find($inventoryId->inventory_id);
        $inventory_id = $inventory_id->id;
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
                        return back();
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
                if(empty($request->purchase_return_quantity[$i]) || $request->purchase_return_quantity[$i] != ' '){
                    $purchaseReturnDetail = new PurchaseReturnDetail();
                    $purchaseReturnDetail->purchase_return_id = $purchaseReturn ->id;
                    $purchaseReturnDetail->location_id = $request->location_id;
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

                    $stock = Stock::where('product_id',$request->purchase_product_id[$i])->where('inventory_id',$request->location_id)->first();
                    // return $stock;
                    $stock->purchase_qty -= $request->purchase_return_quantity[$i];
                    $stock->save();

                }
               
            }
            $product_purchase->grand_total_amount -=  $request->purchase_grand_total_price;
            $product_purchase->total_discount -= $totalDiscountPrice;
             $product_purchase->save();
           return redirect()->route('return.product');  

    }
}
