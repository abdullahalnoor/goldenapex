<?php



Route::get('/', function () {
    return view('admin.login.login');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/* Add invoice */
Route::get('/invoice/manage', 'invoiceController@index');
Route::post('/invoice/save', 'invoiceController@save');
Route::get('/invoice/create', 'invoiceController@create');
Route::get('/invoice/edit/{id}', 'invoiceController@edit');
Route::post('/invoice/update', 'invoiceController@update');
Route::get('/invoice/delete/{id}', 'invoiceController@delete');

Route::get('/pdf/invoice/{id}/{type}','invoiceController@invoiceProductPDF')->name('pdf.invoice.product');


/* End invoice */


/* Add category */
Route::get('/category/save', 'categoryController@index');
Route::post('/category/save', 'categoryController@save');
Route::get('/category/manage', 'categoryController@manage');
Route::get('/category/edit/{id}', 'categoryController@edit');
Route::post('/category/edit', 'categoryController@update');
Route::get('/category/delete/{id}', 'categoryController@delete');



/* End category */


/* inventory location*/
Route::get('/location/manage','LocationController@manage')->name('location.manage');
Route::get('/location/add','LocationController@create')->name('location.create');
Route::post('/location/add','LocationController@store');
Route::get('/location/edit/{id}','LocationController@edit')->name('location.edit');
Route::post('/location/update','LocationController@update')->name('location.update');


/* end inventory location*/


/* start godown*/
Route::get('/godown/manage','GodownController@manage')->name('godown.manage');
Route::get('/godown/add','GodownController@create')->name('godown.create');
Route::post('/godown/add','GodownController@store');
Route::get('/godown/edit/{id}','GodownController@edit')->name('godown.edit');
Route::post('/godown/update','GodownController@update')->name('godown.update');
/* end  godown*/


/*  product purchase*/
Route::get('/product/purchase','ProductPurchaseController@purchaseProduct')->name('purchase.product');
Route::post('/product/purchase','ProductPurchaseController@savePurchaseProductIfo');
Route::get('/manage/product/purchase','ProductPurchaseController@managePurchaseProduct')->name('manage.purchase.product');
Route::get('/edit/product/purchase/{id}','ProductPurchaseController@editPurchaseProduct')->name('edit.purchase.product');
Route::post('/update/product/purchase','ProductPurchaseController@updatePurchaseProduct')->name('update.purchase.product');
Route::get('/delete/product/purchase/{id}','ProductPurchaseController@deletePurchaseProduct')->name('delete.purchase.product');
Route::get('/get/product-info/{id}/{sotck}/{type}','ProductPurchaseController@getProductInfo')->name('get.Product.info');

Route::get('/pdf/product/purchase/{id}/{type?}','ProductPurchaseController@purchaseProductPDF')->name('pdf.purchase.product');



//product return
Route::get('/return/product','ProductReturnController@returnProduct')->name('return.product');
Route::match(['get', 'post'],'/return/purchase/product/{invoice?}','ProductReturnController@returnPurchaseProduct')->name('return.purchase.product');
Route::post('/submit-return/purchase/product','ProductReturnController@submitrReturnPurchaseProduct')->name('submit.return.purchase.product');
Route::match(['get','post'],'/return/sell/product/{invoice?}','ProductReturnController@returnSellProduct')->name('return.sell.product');
Route::post('/submit/return/sell/product','ProductReturnController@submitReturnSellProduct')->name('submit.return.sell.product');


//end product return




// stock
Route::get('/godown/stock','ProductPurchaseController@godownStock')->name('godown.stock');
Route::get('/store/stock','ProductPurchaseController@storeStock')->name('store.stock');
Route::get('/item/stock','ProductPurchaseController@itemStock')->name('item.stock');
/* end product purchase*/




/*Start Unit*/
Route::get('/unit/add', 'unitController@index');
Route::post('/unit/save', 'unitController@save');
Route::get('/unit/manage', 'unitController@manage');
Route::get('/unit/edit/{id}','unitController@edit');
Route::post('/unit/update','unitController@update');
Route::get('/unit/delete/{id}', 'unitController@delete');
/*end Unit*/

/*start supplier*/
Route::get('/supplier/add', 'supplierController@index');
Route::post('/supplier/save', 'supplierController@save');
Route::get('/supplier/manage', 'supplierController@manage');
Route::get('/supplier/edit/{id}','supplierController@edit');
Route::post('/supplier/update','supplierController@update');

/*end supplier*/

/*start customer*/
Route::get('/customer/add', 'customerController@index');
Route::post('/customer/save', 'customerController@save');
Route::get('/customer/manage', 'customerController@manage');
Route::get('/customer/edit/{id}','customerController@edit');
Route::post('/customer/update','customerController@update');
Route::get('/customer/delete/{id}', 'customerController@delete');
Route::get('customer/credit', 'customerController@managecredit');
Route::get('/customer/paid', 'customerController@managepaid');
/*end customer*/


/*start tax*/
Route::get('/tax/add', 'taxController@index');
Route::post('/tax/save', 'taxController@save');
Route::get('/tax/manage', 'taxController@manage');
Route::get('/tax/edit/{id}','taxController@edit');
Route::post('/tax/update','taxController@update');
Route::get('/tax/delete/{id}', 'taxController@delete');
/*end tax*/


/*start product*/
Route::get('/product/add', 'productController@index')->name('add.product');
Route::post('/product/save', 'productController@save')->name('product.save');
Route::get('/product/manage', 'productController@manage');
Route::get('/product/edit/{id}','productController@edit');
Route::post('/product/update','productController@update')->name('product.update');
Route::get('/product/delete/{id}', 'productController@delete')->name('product.delete');
/*end Product*/

/*start bank*/
Route::get('/bank/add', 'bankController@index');
Route::post('/bank/save', 'bankController@save');
Route::get('/bank/manage', 'bankController@manage');
Route::get('/bank/edit/{id}','bankController@edit');
Route::post('/bank/update','bankController@update');
Route::get('/bank/transaction', 'bankController@transaction');
/*end bank*/

/*Office loan start*/
Route::get('/officeloan/add', 'officeloadController@index');
Route::post('/officeloan/save', 'officeloadController@save');
Route::get('/officeloan/loan', 'officeloadController@loan');
Route::get('/officeloan/payment', 'officeloadController@payment');
Route::get('/loan/manage', 'officeloadController@manageloan');
Route::get('/officeloan/manage', 'officeloadController@manage');
Route::get('/officeloan/edit/{id}','officeloadController@edit');
Route::post('/officeloan/update','officeloadController@update');
Route::get('/officeloan/transaction', 'officeloadController@transaction');
/*Office loan end*/


/*start admin employee*/
Route::get('/employee/add', 'employeeController@index');
Route::post('/employee/save', 'employeeController@save')->name('empsave');
Route::get('/employee/manage', 'employeeController@manage');
Route::get('/employee/edit/{id}','employeeController@edit');
Route::post('/employee/update','employeeController@update');
Route::get('/employee/delete/{id}', 'employeeController@delete');

/*end admin employee*/

/*start marketing*/
Route::get('/marketing/order', 'marketingReportController@order');
Route::get('/marketing/due/collection', 'marketingReportController@due');
/*end marketing*/


/* employee start*/
Route::prefix('employee')->group(function() {
  Route::get('/login', 'Auth\employeeLoginController@showLoginForm')->name('employee.login');
  Route::post('/login', 'Auth\employeeLoginController@login')->name('employee.login.submit');
  Route::get('/', 'employeeController@dashboardindex')->name('employee.dashboard');
  Route::get('/logout', 'Auth\employeeLoginController@logout')->name('employee.logout');
  Route::post('/logout', 'Auth\employeeLoginController@logout')->name('employee.logout');
  Route::get('/register','employeeRegisterController@RegistrationForm')->name('employee.register');
  Route::post('/register','employeeRegisterController@cregister')->name('employee.register.submit');
// Password reset route...
  Route::post('/password/email', 'Auth\employeeForgotPasswordController@sendResetLinkEmail')->name('employee.password.email');
  Route::get('/password/reset', 'Auth\employeeForgotPasswordController@showLinkRequestForm')->name('employee.password.request');
  Route::post('/password/reset', 'Auth\employeeResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\employeeResetPasswordController@showResetForm')->name('employee.password.reset');
  
  //update employee
  Route::get('/update', 'employeeRegisterController@update')->name('employee.update');
  Route::post('/updatesave', 'employeeRegisterController@updatesave')->name('employee.update.save');
});

Route::get('employee/order', 'employeeController@order');
Route::post('/employee/order/save', 'employeeController@ordersave')->name('order.save');

Route::get('/employee/collection', 'employeeController@collection');
Route::post('/employee/collection/save', 'employeeController@collectionsave')->name('collection.save');

/* employee end*/

