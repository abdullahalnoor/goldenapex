<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Godown;

class GodownController extends Controller
{
    public function manage(){
        $godowns = Godown::orderBy('id','desc')->paginate();
        return view('admin.godown.managegodown',[
            'godowns' => $godowns,
        ]);
    }
    public function  create(){
        return view('admin.godown.addgodown');
    }
    public function store(Request $request){
        $godown  = new Godown();
        $godown->name = $request->name;
        $godown->address = $request->address;
        $godown->mobile = $request->mobile;
        $godown->status = $request->status;
        $godown->save();
        return redirect()->route('godown.manage')->with('message','Store Added Successfully');
    
    }

    public function  edit($id){
        $godown  =  Godown::find($id);
        return view('admin.godown.editgodown',[
            'godown' => $godown,
        ]);
    }

    public function  update(Request $request){
        $godown  =  Godown::find($request->id);
        $godown->name = $request->name;
        $godown->address = $request->address;
        $godown->mobile = $request->mobile;
        $godown->status = $request->status;
        $godown->save();
        return redirect()->route('godown.manage')->with('message','Store Update Successfully');
    }

}
