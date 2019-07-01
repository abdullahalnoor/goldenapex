<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductGrade;

class ProductGradeController extends Controller
{
    public function index(){
        $productGrades = ProductGrade::paginate(10);
        // return $category;
    	return view('admin.product-grade.addgrade',[
            'productGrades'=>$productGrades,
        ]);
    }

    public function save(Request $request){
        // return $request->all();

    	$productGrade = new ProductGrade();
    	$productGrade->name = $request->name;
    	$productGrade->price = $request->price;
    	$productGrade->save();

    	return redirect('/product/grade/manage')->with('message','Product Grade Added Successfully');
    }

    public function manage(){
        $productGrade =  ProductGrade::paginate(10);
        return view('admin.product-grade.manageproductgrade',[
            'productGrade' => $productGrade
        ]);
    }

    public function edit($id){
        $productGrade = ProductGrade::where('id',$id)->first();
        return view('admin.product-grade.editproductgrade',[
            'productGrade' => $productGrade,
        ]);
    }

    public function update(Request $request){
        $productGrade =  ProductGrade::find($request->id);
    	$productGrade->name = $request->name;
    	$productGrade->price = $request->price;
    	$productGrade->save();
    

    	return redirect('/product/grade/manage')->with('message','Product Grade Updated Successfully');


    }

    public function delete($id){
        $productGrade = ProductGrade::where('id',$id)->first();
        $productGrade->delete();

        return redirect('/product/grade/manage')->with('message','Product Grade Deleted Successfully.');
    }
}
