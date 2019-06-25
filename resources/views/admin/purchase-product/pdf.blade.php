<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{str_replace(" ", "_", $suplier->name.'_'.'Purchase_Invoice_No_'.$product_purchase->purchase_invoice_no)}} </title>
    <style>
    * {
        font-size: 14px;
    }
        table:nth-child(1) {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table:nth-child(1) tr {
            border-right: 1px solid black;
            border-left: 1px solid black;
            border-top: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        table:nth-child(1) td {
            padding: 8px;
            text-align: center;
        }

        /* end */
        table:nth-child(2) {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table:nth-child(2) th {
            border: 1px solid black;
            text-align: center;
            padding: 2px;
        }

        table:nth-child(2) td {
            border-right: 1px solid black;
            border-left: 1px solid black;
            text-align: left;
            padding: 2px;
            text-align: center;
        }

       

        table:nth-child(3) {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        table:nth-child(3) td {
            border: 1px solid black;
            text-align: left;
            padding: 2px;
        }

        table:nth-child(3) td {
            border-right: 1px solid black;
            text-align: left;
            padding: 2px;
            text-align: center;
        }

        table:nth-child(3) td:first-child {
            border-left: 1px solid black;

        }

        .text-right {
            text-align: right;
        }

   

        .row {
            width: 100%;
        }

       
    </style>
</head>

<body>

    <table>
        <tr>
            <td colspan="5">
                <h1 style="margin-bottom: 5px;text-transform:uppercase;font-size:20px;">comfort foam & mattress</h1>
                <address style="font-size:12px;">
                    Address : 68/69 CONCEPT TOWER ,GREEN ROAD,DHAKA-1205 <br />
                  
                </address>
                <h4 style="text-transform:uppercase;margin-top: 5px;font-size:18px;">Purchase Invoice</h4>
            </td>
        </tr>
        <tr style="width:100%;text-align: center">
            <td style="text-align: left">Invoice No : {{$product_purchase->purchase_invoice_no}} </td>
            <td style="text-align: right" colspan="4">Date : {{date("d/m/Y")}} </td>
        </tr>
        <tr style="width:100%;text-align: center">
            <td style="text-align: left" colspan="3">
                <b>Suplier Information</b><br />
                <address style="font-size:14px;">
                    Name    : {{$suplier->name}} <br />
                    Address : {{$suplier->address}} <br />
                    Phone   : {{$suplier->mobile}} <br />
                    E-mail  : {{$suplier->email}} <br />
                   <br />
                </address>
            </td>
            <td colspan="2" style="text-align: right">
                <!-- invoice no : 0100000<br>
                        Date      : 01/01/2000   -->
            </td>
        </tr>
    </table>



    <table>
        <tr>
            <th style="width: 5%;">Sl</th>
            <th style="width: 40%;">Item</th>
            <th style="width: 15%;">Queantiy</th>
            <th style="width: 15%;">Unit Price</th>
            <th style="width: 25%;">Amount</th>
        </tr>

        <tbody>
          @php
          $i = 1;
          $subTotal = 0;
          @endphp
          @foreach ($product_purchase_details as $purchase_detail)
          <tr>
              <td style="width: 5%;">{{$i++}}</td>
              <td style="width: 40%;">
                @foreach ($products as $product)
                @if ($product->id == $purchase_detail->product_id)
                    {{$product->product_name}}
                @endif
                    
                @endforeach
               
            </td>
              <td style="width: 15%;">{{$purchase_detail->quantity}}</td>
              <td style="width: 15%;">{{$purchase_detail->rate}}</td>
              <td style="width: 25%;">{{ $total = $purchase_detail->quantity * $purchase_detail->rate }}</td>
          </tr>
          @php($subTotal += $total )
          @endforeach
        </tbody>


    </table>
    <table>
        <tbody>

            <tr>
                <td style="text-align: right" colspan="4">Sub Total :</td>
                <td>{{$subTotal}}</td>
            </tr>
            <tr>
            
                <td style="text-align: right" colspan="4">Discount :</td>
                @php( $total =  $product_purchase->total_discount +  $product_purchase->grand_total_amount)
                @if ($total != 0)
                @php( $discount = $product_purchase->total_discount /$total)
                @php($discount_per = $discount * 100)
                @endif
               
                
                
                <td style="width: 25%;">{{$product_purchase->total_discount}}</td>
            </tr>
            
            
            <tr>
                <td style="text-align: right" colspan="4">Grand Total :</td>
                <td style="width: 25%;">{{ $product_purchase->grand_total_amount}}</td>
            </tr>
        </tbody>
    </table>
    </div>
    <div style="position: fixed;bottom:50px;">
    
        <p style="float:left;">

           <span style="border-top:1px solid black">Signatur of Supplier</span>
       </p>
          <p style="float:right;">
           <span style="border-top:1px solid black">Signatur of Proprietor</span>
         </p>
     
   </div>

</body>

</html>