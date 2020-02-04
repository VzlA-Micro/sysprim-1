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
        $catastral->regime_horizontal = $request->input('regimen_horizontal');
        $catastral->value_edification = $request->input('value_edificacion');
        $catastral->save();
    }

    public function show() {
        $catastral = CatastralConstruccion::all();
        return view('modules.catastral-construction.read', ['catastral' => $catastral]);

    }

    public function details($id) {
        $catastral = CatastralConstruccion::find($id);
        return view('modules.catastral-construction.details', ['catastral' => $catastral]);
    }

    public function update(Request $request) {
        $id = $request->input('id');
        $accessory = CatastralConstruccion::find($id);
        $accessory->name = $request->input('name');
        $accessory->value = $request->input('value');
        $accessory->update();
    }





}
