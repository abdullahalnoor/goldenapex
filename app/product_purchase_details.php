<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Stock;

class product_purchase_details extends Model
{
    


    public function availableQty($data){
        if($data->inventory_id != ''){
            $stock  = \App\Stock::where('product_id',$data->product_id)->where('inventory_id',$data->inventory_id)->first();
        }else{
            $stock  = \App\Stock::where('product_id',$data->product_id)->where('godown_id',$data->godown_id)->first();
        }
        return $stock->purchase_qty - $data->quantity ;
    }

    

}
