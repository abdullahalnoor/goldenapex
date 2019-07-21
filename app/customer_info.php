<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customer_info extends Model
{
    public function paidCustomer($id){
        $customerPayment = CustomerPayment::where('customer_id',$id)->get();
        $totalPaidAmount = $customerPayment->whereIn('type',[1,2])->sum('payment_total');
        $totalDueAmount = $customerPayment->whereIn('type',0)->sum('payment_total');
        $paidCustomer =  $totalPaidAmount - $totalDueAmount;
        if( $paidCustomer >= 0 ){
            return true;
        }
        return false;

    }

    public function customerPaidAmount($id){
        $customerPayment = CustomerPayment::where('customer_id',$id)->get();
        $totalPaidAmount = $customerPayment->whereIn('type',[1,2])->sum('payment_total');
        $totalDueAmount = $customerPayment->whereIn('type',0)->sum('payment_total');
        $customerPaidAmount =  $totalPaidAmount - $totalDueAmount;
        if( $customerPaidAmount >= 0 ){
            return $customerPaidAmount;
        }
        
    }

    public function customerCreditAmount($id){
        $customerPayment = CustomerPayment::where('customer_id',$id)->get();
        $totalPaidAmount = $customerPayment->whereIn('type',[1,2])->sum('payment_total');
        $totalDueAmount = $customerPayment->whereIn('type',0)->sum('payment_total');
        $customerCreditAmount =  $totalPaidAmount - $totalDueAmount;
        if( $customerCreditAmount < 0 ){
            return -($customerCreditAmount);
        }
        
    }
}
