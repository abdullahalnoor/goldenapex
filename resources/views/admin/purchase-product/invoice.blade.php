@extends('admin.master')

@section('mainContent')

@section('title')
	Manage Purchase Product
@endsection

<br>
    <section class="content">

        <div class="container-fluid">
            <!-- Breadcrumb-->
           <div class="row pt-2 pb-2">
              <div class="col-sm-9">
                  <h4 class="page-title">Invoice</h4>
                  <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javaScript:void();">Rocker</a></li>
                  <li class="breadcrumb-item"><a href="javaScript:void();">Pages</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Invoice</li>
               </ol>
             </div>
             <div class="col-sm-3">
             <div class="btn-group float-sm-right">
              <button type="button" class="btn btn-outline-primary waves-effect waves-light"><i class="fa fa-cog mr-1"></i> Setting</button>
              <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown">
              <span class="caret"></span>
              </button>
              <div class="dropdown-menu">
                <a href="javaScript:void();" class="dropdown-item">Action</a>
                <a href="javaScript:void();" class="dropdown-item">Another action</a>
                <a href="javaScript:void();" class="dropdown-item">Something else here</a>
                <div class="dropdown-divider"></div>
                <a href="javaScript:void();" class="dropdown-item">Separated link</a>
              </div>
            </div>
           </div>
           </div>
          <!-- End Breadcrumb-->
            <div class="card">
                <div class="card-body">
                        <!-- Content Header (Page header) -->
                        <section class="content-header">
                          <h3>
                            Invoice
                            <small>#007612</small>
                          </h3>
                        </section>
      
                        <!-- Main content -->
                        <section class="invoice">
                          <!-- title row -->
                          <div class="row mt-3">
                            <div class="col-lg-6">
                              <h4><i class="fa fa-globe"></i> Company Name</h4>
                            </div>
                            <div class="col-lg-6">
                             <h5 class="float-sm-right">Date: 2/10/2014</h5>
                            </div>
                          </div>
                          
                          <hr>
                          <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                              From
                              <address>
                               <strong>Kudiland Inc</strong><br>
                                543 suthpark drive<br>
                                Boston, MA 94107<br>
                                Phone: (555) 539-1444<br>
                                Email: info@example.com
                              </address>
                            </div><!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                              To
                              <address>
                                <strong>Sandra Mekoya</strong><br>
                                543 suthpark drive<br>
                                Boston, MA 94107<br>
                                Phone: (555) 539-1444<br>
                                Email: support@example.com
                              </address>
                            </div><!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                              <b>Invoice #007612</b><br>
                              <br>
                              <b>Order ID:</b> 4F3S8J<br>
                              <b>Payment Due:</b> 2/22/2014<br>
                              <b>Account:</b> 968-34567
                            </div><!-- /.col -->
                          </div><!-- /.row -->
      
                          <!-- Table row -->
                          <div class="row">
                            <div class="col-12 table-responsive">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Qty</th>
                                    <th>Product</th>
                                    <th>Serial #</th>
                                    <th>Description</th>
                                    <th>Subtotal</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>Call of Duty</td>
                                    <td>455-981-221</td>
                                    <td>El snort testosterone trophy driving gloves handsome</td>
                                    <td>$64.50</td>
                                  </tr>
                                  <tr>
                                    <td>1</td>
                                    <td>Need for Speed IV</td>
                                    <td>247-925-726</td>
                                    <td>Wes Anderson umami biodiesel</td>
                                    <td>$50.00</td>
                                  </tr>
                                  <tr>
                                    <td>1</td>
                                    <td>Monsters DVD</td>
                                    <td>735-845-642</td>
                                    <td>Terry Richardson helvetica tousled street art master</td>
                                    <td>$10.70</td>
                                  </tr>
                                  <tr>
                                    <td>1</td>
                                    <td>Grown Ups Blue Ray</td>
                                    <td>422-568-642</td>
                                    <td>Tousled lomo letterpress</td>
                                    <td>$25.99</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div><!-- /.col -->
                          </div><!-- /.row -->
      
                          <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-lg-6 payment-icons">
                              <p class="lead">Payment Methods:</p>
                              <img src="assets/images/payment-icons/visa-dark.png" alt="Visa">
                              <img src="assets/images/payment-icons/mastro-dark.png" alt="Mastercard">
                              <img src="assets/images/payment-icons/american-dark.png" alt="American Express">
                              <img src="assets/images/payment-icons/paypal-dark.png" alt="Paypal">
                              <p class="text-muted bg-light p-2 mt-3 border rounded">
                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                              </p>
                            </div><!-- /.col -->
                            <div class="col-lg-6">
                              <p class="lead">Amount Due 2/22/2014</p>
                              <div class="table-responsive">
                                <table class="table">
                                  <tbody>
                                  <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td>$250.30</td>
                                  </tr>
                                  <tr>
                                    <th>Tax (9.3%)</th>
                                    <td>$10.34</td>
                                  </tr>
                                  <tr>
                                    <th>Shipping:</th>
                                    <td>$5.80</td>
                                  </tr>
                                  <tr>
                                    <th>Total:</th>
                                    <td>$265.24</td>
                                  </tr>
                                </tbody>
                                </table>
                              </div>
                            </div><!-- /.col -->
                          </div><!-- /.row -->
      
                          <!-- this row will not appear when printing -->
                          <hr>
                          <div class="row no-print">
                            <div class="col-lg-3">
                              <a href="javascript:window.print();" target="_blank" class="btn btn-outline-secondary m-1"><i class="fa fa-print"></i> Print</a>
                              </div>
                              <div class="col-lg-9">
                              <div class="float-sm-right">
                               <button class="btn btn-success m-1"><i class="fa fa-credit-card"></i> Submit Payment</button>
                               <button class="btn btn-primary m-1"><i class="fa fa-download"></i> Generate PDF</button>
                              </div>
                            </div>
                          </div>
                        </section><!-- /.content -->
                </div>
            </div>
      
          </div>
          <!-- End container-fluid-->
    </section>
@endsection

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
  });
  </script>


