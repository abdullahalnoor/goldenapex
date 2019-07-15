<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\invoice;
use App\invoice_details;
use App\product;

class CustomerPayment extends Model
{
    public function invoiceInfo($id){
        $invoice = invoice::find($id);
        $sell_invoice_no = $invoice->sell_invoice_no;
        $invoice_details = invoice_details::where('invoice_id',$invoice->id)->first();
        $product  = product::find($invoice_details->product_id);
        $product_name = $product->product_name;
        $data = [
            'sell_invoice_no' => $sell_invoice_no,
            'product_name' => $product_name,
        ];
        return $data;
    }
   
}
