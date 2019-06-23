<?php

namespace App\Http\Controllers;
use App\employee;
use Illuminate\Http\Request;

class marketingReportController extends Controller
{
    public function order(){
    	$employee = employee::all();
    	return view('admin.report.order_report', get_defined_vars());
    }

    public function due(){
    	$employee = employee::all();
    	return view('admin.report.due_colection', get_defined_vars());
    }
}
