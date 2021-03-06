<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{str_replace(" ", "_", $customer_info->customer_name.'_'.'Challan No'.'_'.$invoice->sell_invoice_no)}} </title>
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
            border-bottom: 1px solid black;
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
        .page-break {
    page-break-after: always;
}

       
    </style>
</head>

<body>

    <main>
            <table> 
                    <tr>
                        <td colspan="5">
                            <h1 style="margin-bottom: 5px;text-transform:uppercase;font-size:20px">comfort foam & mattress</h1>
                            <address style="font-size:12px;">
                                Address : 68/69 CONCEPT TOWER ,GREEN ROAD,DHAKA-1205 <br />
                               
                            </address>
                            <h4 style="text-transform:uppercase;margin-top: 5px;font-size:18px"> Challan</h4>
                        </td>
                    </tr>
                    <tr style="width:100%;text-align: center">
                        <td style="text-align: left">Challan No : {{$invoice->sell_invoice_no}} </td>
                        <td style="text-align: right" colspan="4">Date : {{date("d/m/Y")}} </td>
                    </tr>
                    <tr style="width:100%;text-align: center">
                        <td style="text-align: left" colspan="3">
                            <b>Customer Information</b><br />
                            <address style="font-size:14px;">
                                Name    : {{$customer_info->customer_name}} <br />
                                Address : {{$customer_info->customer_address}} <br />
                                Phone   : {{$customer_info->customer_mobile}} <br />
                               
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
                        <th style="width: 15%;">Item </th>
                        <th style="width: 25%;">Description </th>
                        <th style="width: 15%;">Quantity</th>
                       
                    </tr>
            
                    <tbody>
                      @php
                      $i = 1;
                      
                      $subTotal = 0;
                      @endphp
                      @foreach ($invoice_details as $detail)
                      <tr>
                          <td style="width: 5%;">{{$i++}}</td>
                          <td style="width: 15%;text-align:left">
                                @foreach ($products as $product)
                                @if ($product->id == $detail->product_id)
                                    {{$product->product_name}}
                                @endif
                            @endforeach
                        </td>
                          <td style="width: 25%;text-align:left">
                           
                            @foreach ($productCft as $cft)
                            @foreach ($productGrade as $grade)
                                @if($grade->id == $cft->grade_id)
                                @if($detail->product_size == $cft->id)
                                <option value="{{$cft->id}}">{{$cft->length.'x'.$cft->width.'x'.$cft->height.' '.$grade->name}}</option>
                                @endif
                                @endif
                            @endforeach
                            @endforeach
                        </td>
                          <td style="width: 15%;">{{$detail->quantity}}</td>
                        
                      </tr>
                     
                    
                      @endforeach
                    </tbody>
            
            
                </table>
              
    </main>
   
   <div style="position: fixed;bottom:50px;">
    
        <p style="float:left;">

           <span style="border-top:1px solid black">Signatur of Customer</span>
       </p>
          <p style="float:right;">
           <span style="border-top:1px solid black">Signatur of Proprietor</span>
         </p>
     
   </div>
  

</body>

</html>