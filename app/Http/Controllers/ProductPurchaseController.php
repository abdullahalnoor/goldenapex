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
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
use PDF;



class ProductPurchaseController extends Controller
{
    //godown-stock.blade

    public function productData(Request $request)
    {
        $columns = array( 
            2 => 'name', 
            3 => 'code',
            4 => 'brand_id',
            5 => 'category_id',
            6 => 'qty',
            7 => 'unit_id',
            8 => 'price' 
        );
        
        $totalData = Product::where('is_active', true)->count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value'))){
            $products = Product::offset($start)
                        ->where('is_active', true)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();
        }
        else
        {
            $search = $request->input('search.value'); 
            $products =  Product::where([
                            ['name', 'LIKE', "%{$search}%"],
                            ['is_active', true]
                        ])->orWhere([
                            ['code', 'LIKE', "%{$search}%"],
                            ['is_active', true]
                        ])
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)->get();

            $totalFiltered = Product::where([
                            ['name','LIKE',"%{$search}%"],
                            ['is_active', true]
                        ])->orWhere([
                            ['code', 'LIKE', "%{$search}%"],
                            ['is_active', true]
                        ])->count();
        }
        $data = array();
        if(!empty($products)) 
        {
            foreach ($products as $key=>$product)
            {
                $nestedData['id'] = $product->id;
                $nestedData['key'] = $key;
                $nestedData['image'] = '<img src="'.url('public/images/product',$product->image).'" height="80" width="80">';
                $nestedData['name'] = $product->name;
                $nestedData['code'] = $product->code;
                if($product->brand_id)
                    $nestedData['brand'] = Brand::find($product->brand_id)->title;
                else
                    $nestedData['brand'] = "N/A";
                $nestedData['category'] = Category::find($product->category_id)->name;
                $nestedData['qty'] = $product->qty;
                if($product->unit)
                    $nestedData['unit'] = Unit::find($product->unit_id)->unit_code;
                else
                    $nestedData['unit'] = 'N/A';
                
                $nestedData['price'] = $product->price;
                $nestedData['options'] = '<div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.trans("file.action").'
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';
                if(in_array("products-edit", $request['all_permission']))
                    $nestedData['options'] .= '<li>
                            <a href="'.route('products.edit', ['id' => $product->id]).'" class="btn btn-link"><i class="fa fa-edit"></i> '.trans('file.edit').'</a>
                        </li>';
                if(in_array("products-delete", $request['all_permission']))
                    $nestedData['options'] .= \Form::open(["route" => ["products.destroy", $product->id], "method" => "DELETE"] ).'
                            <li>
                              <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> '.trans("file.delete").'</button> 
                            </li>'.\Form::close().'
                        </ul>
                    </div>';
                // data for product details by one click
                if($product->tax_id)
                    $tax = Tax::find($product->tax_id)->name;
                else
                    $tax = "N/A";

                if($product->tax_method == 1)
                    $tax_method = trans('file.Exclusive');
                else
                    $tax_method = trans('file.Inclusive');

                $nestedData['product'] = array( '[ "'.$product->type.'"', ' "'.$product->name.'"', ' "'.$product->code.'"', ' "'.$nestedData['brand'].'"', ' "'.$nestedData['category'].'"', ' "'.$nestedData['unit'].'"', ' "'.$product->cost.'"', ' "'.$product->price.'"', ' "'.$tax.'"', ' "'.$tax_method.'"', ' "'.$product->alert_quantity.'"', ' "'.$product->product_details.'"', ' "'.$product->id.'"', ' "'.$product->product_list.'"', ' "'.$product->qty_list.'"', ' "'.$product->price_list.'"', ' "'.$product->qty.'"]'
                );
                $nestedData['imagedata'] = DNS1D::getBarcodePNG($product->code, $product->barcode_symbology);
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data);
    }

    public function getProductInfo($productId,$inventoryId,$inventoryType){
        $productAvailability;
        if($inventoryType == 'inventory'){
            $productAvailability = Stock::where('inventory_id',$inventoryId)->where('product_id',$productId)->first();
        }elseif($inventoryType == 'godown'){
            $productAvailability = Stock::where('godown_id',$inventoryId)->where('product_id',$productId)->first();
        }
        return $productAvailability;
    }

    public function godownStock(){

        $suppliers = Supplier::find(1);



        $stocks1 = DB::table("product_purchases")
        ->join('suppliers','suppliers.id','=','product_purchases.supplier_id')
        ->distinct()
	    ->groupBy("product_purchases.supplier_id")
	    ->get(
            array(
                DB::raw('SUM(product_purchases.grand_total_amount) as grand_total_amount'),
                DB::raw('SUM(product_purchases.total_discount) as total_discount'),
                DB::raw('product_purchases.supplier_id as supplier_id'),
                
                
              )
        )->toArray();

                 // return $stocks1 ;




//                  $latestPosts = DB::table('posts')
//                  ->select('user_id', DB::raw('MAX(created_at) as last_post_created_at'))
//                  ->where('is_published', true)
//                  ->groupBy('user_id');

// $users = DB::table('users')
//       ->joinSub($latestPosts, 'latest_posts', function ($join) {
//           $join->on('users.id', '=', 'latest_posts.user_id');
//       })->get();


                //  $latestPosts = DB::table('product_purchase_details')
                //  ->select('purchase_id', DB::raw('SUM(quantity) as quantity'), DB::raw('MAX(created_at) as last_post_created_at'))
                // //  ->where('is_published', true)
                //  ->groupBy('purchase_id');

                // $users = DB::table('product_purchases')
                //     ->joinSub($latestPosts, 'latest_posts', function ($join) {
                //         $join->on('product_purchases.id', '=', 'latest_posts.purchase_id');
                //     })->get();


                //     return $users;

                $users =  DB::table('product_purchases')
                ->join('product_purchase_details', function ($join) {
                    $join->on('product_purchases.id', '=', 'product_purchase_details.purchase_id');
                })
                ->get();
                // return $users->groupBy('supplier_id');




        $stocks = DB::table("product_purchases")
        ->join('product_purchase_details','product_purchases.id','=','product_purchase_details.purchase_id')
	    ->groupBy("product_purchase_details.purchase_id")
	    ->get(
            array(
                DB::raw('SUM(quantity) as quantity'),
                DB::raw('SUM(total_amount) as total_amount'),
                DB::raw('SUM(discount) as discount'),
                DB::raw('purchase_id as purchase_id'),            
                          
              )
        )->toArray();
        // or
        // ->get()
        // ->groupBy("supplier_id");

        // $stocks = $stocks->map(function ($stock) {
        //     return $stock->sum('total_amount');
        // });

        // return $stocks ;


        // $projects = DB::table('product_purchases')
        // ->join('product_purchase_details', 'product_purchases.id', '=', 'product_purchase_details.purchase_id')
        // ->select('product_purchases.*','product_purchase_details.*' )
        // ->get()
        // ->groupBy('supplier_id');

        // return  $projects;
       
       
        // foreach($projects as $project){

        // }
        // array(
        //     DB::raw('SUM(purchase_qty) as purchase_qty'),
        //     DB::raw('SUM(sell_qty) as sell_qty'),
        //     DB::raw('product_id as product_id'),
        //   )

        

       
        $stocks = Stock::where('godown_id','>=','0')->get()->groupBy('godown_id');
        $products = product::all();
        $godowns = Godown::all();
      
        return view('admin.stock.godown-stock',get_defined_vars());
    }

    public function storeStock(){
    
        $stocks = Stock::where('inventory_id','>=','0')->get()->groupBy('inventory_id');
        // $stocks = Stock::where('inventory_id','>=','0')->get(['inventory_id'])->groupBy('inventory_id');
        $products = product::all();
        $locations = Location::all();
        // return $stocks;
        return view('admin.stock.store-stock',get_defined_vars());
    }

    public function itemStock(){
        // $stocks = Stock::get();
        // $stocks  = $stocks->groupBy('product_id');
        // return $stocks;
        // $stocks = DB::table("stocks")  
	    // ->select(DB::raw("SUM(purchase_qty) as purchase"))
	    // ->select(DB::raw("SUM(sell_qty) as sell"))
	    // ->select('purchase', 'sell', 'user_id', 'created_at', 'updated_at')
	    // ->groupBy(DB::raw("product_id"))
	    // ->get();
        // self::select("*"),
        
        $stocks = DB::table("stocks")
	    ->groupBy(DB::raw("product_id"))
	    ->get(
            array(
                DB::raw('SUM(purchase_qty) as purchase_qty'),
                DB::raw('SUM(sell_qty) as sell_qty'),
                DB::raw('product_id as product_id'),
              )
        )->toArray();

     

            //     $result = DB::table('events')->join('attendees', 'events.id', '=', 'attendees.event_id')
            // ->get( array(
            //     DB::raw( 'SUM(attendees.total_raised) AS raised' ),
            //     DB::raw( 'SUM(attendees.total_hours) AS hours' ),
            // ));
      
        // return  $result;

        $products = product::all();
        $godowns = Godown::all();
        return view('admin.stock.item-stock',get_defined_vars());
    }

    public function managePurchaseProduct(){

        $product_purchase = product_purchase::orderBy('id','desc')->paginate(10);
    
        $supplierid = $product_purchase->pluck('supplier_id')->unique();
      
        $suppliers         = Supplier::whereIn('id',$supplierid)->get();
    
        $totalPurchasePrice = product_purchase::sum('grand_total_amount');

        return view('admin.purchase-product.manage-purchase-product',[
            'product_purchase' => $product_purchase,
            'suppliers'         => $suppliers,
            'totalPurchasePrice'         => $totalPurchasePrice,
            
        ]);
    }

    public function purchaseProduct(){
        $suppliers = Supplier::all();
        $products = product::all();
        $locations = Location::all();
        $godowns = Godown::all();
    
        $lastInvoiceID = product_purchase::orderBy('id', 'DESC')->pluck('purchase_invoice_no')->first();
        if(empty( $lastInvoiceID)){
            $newInvoiceID = '1001';
        }else{
            $newInvoiceID = $lastInvoiceID + 1;
        }

       

        return view('admin.purchase-product.purchase-product',[
            'suppliers' => $suppliers,
            'products' => $products,
            'locations' => $locations,
            'godowns' => $godowns,
            'newInvoiceID' => $newInvoiceID,
        ]);
    }

    public function savePurchaseProductIfo(Request $request){


       
        if(!empty($request->inventory_id && !empty($request->godown_id))){
            return back()->with('danger','Select one Godown or Store. Not Both..');
        }

        $inputs = Input::except(['_token','challan_no','purchase_date','total_discount','grand_total_price','supplier_id','status','purchase_details','payment_type',]);

        $lastInvoiceID = product_purchase::orderBy('id', 'DESC')->pluck('purchase_invoice_no')->first();
        if(empty( $lastInvoiceID)){
            $newInvoiceID = '1001';
        }else{
            $newInvoiceID = $lastInvoiceID + 1;
        }
       

        $product_purchase = new product_purchase();
        $product_purchase->challan_no = $request->challan_no;
        $product_purchase->supplier_id = $request->supplier_id;
        $product_purchase->status = $request->status;
        $product_purchase->purchase_details = $request->purchase_details;
        $product_purchase->purchase_date = $request->purchase_date;
        $product_purchase->payment_type = $request->payment_type;
        $product_purchase->purchase_invoice_no = $newInvoiceID;
       
        $grand_total = 0;
        // $dis_percent = 0;
        
        if(count($inputs) > 0){
            for($i = 0; $i < count($inputs['product_quantity']); $i++){
                $total_price =  $request->product_quantity[$i] * $request->product_rate[$i];;
                $grand_total += $total_price;
            } 
        }
        
        $total_discount = $grand_total *  $request->dis_percent;
        $total_discount = $total_discount/100;
        $product_purchase->total_discount = $total_discount;
        $product_purchase->grand_total_amount = $grand_total - $total_discount;
        $product_purchase->save();

        if(count($inputs) > 0){
            for($i = 0; $i < count($inputs['product_quantity']); $i++){
                $detail = new product_purchase_details();
                $detail->purchase_id = $product_purchase->id;

                if(!empty($request->inventory_id)){
                    $detail->inventory_id = $request->inventory_id;
                }else{
                    $detail->godown_id    = $request->godown_id;
                }


                $detail->product_id = $request->products_id[$i];
                $detail->quantity = $request->product_quantity[$i];
                $detail->rate = $request->product_rate[$i];
                $total_price =  $request->product_quantity[$i] * $request->product_rate[$i];

                $discount =  $total_price * $request->dis_percent;
                $discount = $discount/100;
                $detail->discount = $discount ;
                $detail->total_amount = $total_price -$discount;
                $detail->save();

              

                if(!empty($request->inventory_id)){
                    // return 'inventory_id';
                    // StoreStock;
                    $stock = Stock::where('product_id',$detail->product_id)->where('inventory_id',$request->inventory_id)->first();
                    // return $stock;
                    if(!empty($stock)){
                        $stock->purchase_qty  +=  $request->product_quantity[$i];
                        $stock->save();
                    }else{
                        $stock  = new Stock();
                        $stock->inventory_id  = $request->inventory_id;
                        $stock->product_id  = $request->products_id[$i];
                        $stock->purchase_qty  = $request->product_quantity[$i];
                        $stock->save();
                    }


                }elseif(!empty($request->godown_id)){
                    $stock = Stock::where('product_id',$detail->product_id)->where('godown_id',$request->godown_id)->first();
                    // return $stock;
                    if(!empty($stock)){
                        $stock->purchase_qty  +=  $request->product_quantity[$i];
                        $stock->save();
                    }else{
                        $stock  = new Stock();
                        $stock->godown_id  = $request->godown_id;
                        $stock->product_id  = $request->products_id[$i];
                        $stock->purchase_qty  = $request->product_quantity[$i];
                        $stock->save();
                    }
                }


            } 
        }

        return redirect('/manage/product/purchase')->with('message','Product Purchase Successfully.');
      
    }

    public function editPurchaseProduct($id){
        $suppliers = Supplier::all();
        $products = product::all();
        $locations = Location::all();
        $godowns = Godown::all();
        $product_purchase = product_purchase::find($id);

        

        $inventoryId = product_purchase_details::where('purchase_id',$product_purchase->id)->first(['godown_id','inventory_id']);
        //$inventoryId = product_purchase_details::where('purchase_id',$product_purchase->id)->get(['godown_id','inventory_id'])->unique();

        // return $inventoryId->inventory_id;
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
        return view('admin.purchase-product.edit-purchase-product',[
            'product_purchase' => $product_purchase,
            'product_purchase_details'         => $product_purchase_details,
            'suppliers' => $suppliers,
            'products' => $products,
            'locations' => $locations,
            'godowns' => $godowns,
            'inventoryId' => $inventoryId,
            'availableProducts' => $availableProducts,
        ]);
    }

    public function updatePurchaseProduct(Request $request){

        if(!empty($request->inventory_id && !empty($request->godown_id))){
            return back()->with('danger','Select one Godown or Store. Not Both..');
        }

        $inputs = Input::except(['_token','challan_no','purchase_date','total_discount','grand_total_price','supplier_id','status','purchase_details','payment_type',]);

        $product_purchase =  product_purchase::find($request->purchase_id);
        // return $product_purchase;
        // return $product_purchase;
        $product_purchase->challan_no = $request->challan_no;
        $product_purchase->supplier_id = $request->supplier_id;
        $product_purchase->status = $request->status;
        $product_purchase->purchase_details = $request->purchase_details;
        $product_purchase->purchase_date = $request->purchase_date;
        $product_purchase->payment_type = $request->payment_type;
       
        $grand_total = 0;
        
        
        if(count($inputs) > 0){
            for($i = 0; $i < count($inputs['product_quantity']); $i++){
                $total_price =  $request->product_quantity[$i] * $request->product_rate[$i];
                $grand_total += $total_price;
            } 
        }
        // return $grand_total;
        
        $total_discount = $grand_total *  $request->dis_percent;
        $total_discount = $total_discount/100;
        $product_purchase->total_discount = $total_discount;
        $product_purchase->grand_total_amount = $grand_total - $total_discount;
        $product_purchase->save();

        if(count($inputs) > 0){
            for($i = 0; $i < count($inputs['product_quantity']); $i++){
                $detail =  product_purchase_details::where('purchase_id',$product_purchase->id)->where('product_id',$request->products_id[$i])->first();
                // return $detail;
                // minus from stock
                // return $request->inventory_id;
                if(!empty($detail->inventory_id)){
                    $stock = Stock::where('product_id',$detail->product_id)->where('inventory_id',$detail->inventory_id)->first(); 
                        
                    if(!empty($stock)){
                        // return $detail->quantity ;
                        $stock->purchase_qty  -=  $detail->quantity;
                        $stock->save(); 
                    }
                }elseif(!empty($detail->godown_id)){
                    $stock = Stock::where('product_id',$detail->product_id)->where('godown_id',$detail->godown_id)->first();
                    if(!empty($stock)){
                        $stock->purchase_qty  -=  $detail->quantity;
                        $stock->save();
                    }
                }


                if(!empty($detail->inventory_id)){
                    $stock = Stock::where('product_id',$detail->product_id)->where('inventory_id',$detail->inventory_id)->first();
                    
                    if($stock != ''){
                        $stock->purchase_qty  +=  $request->product_quantity[$i];
                        $stock->save();
                    }else{
                        $stock  = new Stock();
                        $stock->inventory_id  = $request->inventory_id;
                        $stock->product_id  = $request->products_id[$i];
                        $stock->purchase_qty  = $request->product_quantity[$i];
                        $stock->save();
                    }


                }elseif($detail->godown_id != ''){
                    $stock = Stock::where('product_id',$detail->product_id)->where('godown_id',$detail->godown_id)->first();
                    // return $stock;
                    if(!empty($stock)){
                        $stock->purchase_qty  +=  $request->product_quantity[$i];
                        $stock->save();
                    }else{
                        $stock  = new Stock();
                        $stock->godown_id  = $request->godown_id;
                        $stock->product_id  = $request->products_id[$i];
                        $stock->purchase_qty  = $request->product_quantity[$i];
                        $stock->save();
                    }
                }


               

            //   return $detail->inventory_id;
                if($detail->inventory_id != ''){
                    $detail->inventory_id = $detail->inventory_id;
                }else{
                    $detail->godown_id    = $detail->godown_id;
                }

                $detail->purchase_id = $product_purchase->id;
                $detail->product_id = $request->products_id[$i];
                $detail->quantity = $request->product_quantity[$i];
                $detail->rate = $request->product_rate[$i];

                $total_price =  $request->product_quantity[$i] * $request->product_rate[$i];

                $discount =  $total_price * $request->dis_percent;
                $discount = $discount/100;
                $detail->discount = $discount ;
                $detail->total_amount = $total_price -$discount;
                $detail->save();

                

            } 
        }

        
        return redirect('/manage/product/purchase')->with('message','Product Updated Successfully.');
    }

    public function deletePurchaseProduct($id){
        $product_purchase = product_purchase::find($id);
        $product_purchase_details = product_purchase_details::where('purchase_id',$product_purchase->id)->get();

        foreach($product_purchase_details as $purchase_details){
            if(!empty($purchase_details->inventory_id)){
                $stock = Stock::where('inventory_id',$purchase_details->inventory_id)->where('product_id',$purchase_details->product_id)->first();
            }elseif(!empty($purchase_details->godown_id)){
                $stock = Stock::where('godown_id',$purchase_details->godown_id)->where('product_id',$purchase_details->product_id)->first();
            }
            $stock->purchase_qty  -=  $purchase_details->quantity;
            $stock->save();
            $purchase_details->delete();
        }
        $product_purchase->delete();

        return redirect('/manage/product/purchase')->with('message','Product Purchase Deleted Successfully.');
    }


    public function purchaseProductPDF($id,$type=null){
        //    Supplier;
        //    product;
        //    Location;
        //    product_purchase;
        //    product_purchase_details;
        $products = product::all();
        $product_purchase = product_purchase::find($id);
        $product_purchase_details = product_purchase_details::where('purchase_id',$product_purchase->id)->get();
        $suplier  = Supplier::where('id',$product_purchase->supplier_id)->first(); 
        $inWorTk = $this->numberTowords((float) $product_purchase->grand_total_amount);

        $pdf = PDF::loadView('admin.purchase-product.pdf',get_defined_vars())->setPaper('a4', 'vertical');
        if($type == 'stream'){
            return $pdf->stream($suplier->name.'_'.'Purchase_Invoice_No_'.$product_purchase->purchase_invoice_no.'.pdf');
        }elseif($type == 'downlaod'){
            return $pdf->download('invoice.pdf');
        }
        
    }

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
    
    
    











    


}//end of class
