<?php

namespace App\Http\Controllers;

use App\Parish;
use Illuminate\Http\Request;
use App\CatastralTerreno;
class CatastralTerrenoController extends Controller
{
    public function manage() {
        return view('modules.catastral-terreno.manage');
    }

    public function create() {
        $parish=Parish::all();
        return view('modules.catastral-terreno.register',['parish'=>$parish]);
    }

    public function store(Request $request) {
        $catastral = new CatastralTerreno();
        $catastral->name = $request->input('name');
        $catastral->parish_id = $request->input('parish_id');
        $catastral->sector_nueva_nomenclatura = $request->input('sector_nueva');
        $catastral->sector_catastral = $request->input('sector_catastral');
        $catastral->value_terreno_vacio =$request->input('value_terreno_vacio');
        $catastral->value_terreno_construccion =$request->input('value_terreno_construccion');
        $catastral->save();
        return response()->json(['status'=>'success'],200);
    }

    public function show() {
        $catastral = CatastralTerreno::orderBy('id','desc')->get();

        return view('modules.catastral-terreno.read', ['catastral' => $catastral,]);

    }

    public function details($id) {
        $catastral = CatastralTerreno::find($id);
        $parish=Parish::all();
        return view('modules.catastral-terreno.details', ['catastral' => $catastral,'parish'=>$parish]);
    }

    public function update(Request $request) {
        $id = $request->input('id');
        $catastral = CatastralTerreno::find($id);
        $catastral->name = $request->input('name');
        $catastral->parish_id = $request->input('parish_id');
        $catastral->sector_nueva_nomenclatura = $request->input('sector_nueva');
        $catastral->sector_catastral = $request->input('sector_catastral');
        $catastral->value_terreno_vacio =$request->input('value_terreno_vacio');
        $catastral->value_terreno_construccion =$request->input('value_terreno_construccion');
        $catastral->update();
        return response()->json(['status'=>'success'],200);
    }
}
