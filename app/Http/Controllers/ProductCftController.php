<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductGrade;
use App\ProductCft;

class ProductCftController extends Controller
{
    public function create(){
        
        $productGrade = ProductGrade::all();
        // return $category;
    	return view('admin.product-cft.addcft',[
           
            'productGrade'=>$productGrade,
        ]);
    }

    public function save(Request $request){
        // return $request->all();

        $productCft = new ProductCft();
        $productGrade = ProductGrade::find($request->grade_id);
    	$productCft->grade_id = $request->grade_id;
    	$productCft->width = $request->width;
    	$productCft->height = $request->height;
    	$productCft->length = $request->length;
      
        $productCft->save();

    	return redirect('/product/cft/manage')->with('message','Product CFT Added Successfully');
    }

    public function manage(){
        $productCft = ProductCft::orderBy('id','DESC')->get();
        // return $productCft;
        $productGrade = ProductGrade::all();
        return view('admin.product-cft.managecft',[
            'productCft' => $productCft,
            'productGrade' => $productGrade,
        ]);
    }

    public function edit($id){
        $productGrade = ProductGrade::all();
        $productCft = productCft::where('id',$id)->first();
        return view('admin.product-cft.editcft',[
            'productCft' => $productCft,
            'productGrade' => $productGrade,
        ]);
    }

    public function update(Request $request){
        $productCft =  ProductCft::find($request->id);
        $productGrade = ProductGrade::find($request->grade_id);
    	$productCft->grade_id = $request->grade_id;
    	$productCft->width = $request->width;
    	$productCft->height = $request->height;
    	$productCft->length = $request->length;
       
        $productCft->save();
    

    	return redirect('/product/cft/manage')->with('message','Product CFT Updated Successfully');


    }

    public function delete($id){
        $productCft = ProductCft::where('id',$id)->first();
        $productCft->delete();

        return redirect('/product/cft/manage')->with('message','Product CFT Deleted Successfully.');
    }
}
