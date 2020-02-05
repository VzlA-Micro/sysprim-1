<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CatastralConstruccion;





class CatastralConstruccionController extends Controller{

    public function manage() {
        return view('modules.catastral-construction.manage');
    }

    public function create() {
        return view('modules.catastral-construction.register');
    }

    public function store(Request $request) {
        $catastral = new CatastralConstruccion();
        $catastral->name = $request->input('name');
        $catastral->value_edificacion = $request->input('value_edification');
        $catastral->regimen_horizontal =$request->input('regimen_horizontal');
        $catastral->save();
        return response()->json(['status'=>'success'],200);
    }

    public function show() {
        $catastral = CatastralConstruccion::orderBy('id','desc')->get();
        return view('modules.catastral-construction.read', ['catastral' => $catastral]);

    }

    public function details($id) {
        $catastral = CatastralConstruccion::find($id);
        return view('modules.catastral-construction.details', ['catastral' => $catastral]);
    }

    public function update(Request $request) {
        $id = $request->input('id');
        $catastral = CatastralConstruccion::find($id);
        $catastral->name = $request->input('name');
        $catastral->value_edificacion = $request->input('value_edification');
        $catastral->regimen_horizontal =$request->input('regimen_horizontal');
        $catastral->update();
        return response()->json(['status'=>'success'],200);
    }





}
