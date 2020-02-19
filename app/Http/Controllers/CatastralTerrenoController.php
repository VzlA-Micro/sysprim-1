<?php

namespace App\Http\Controllers;

use App\Parish;
use Illuminate\Http\Request;
use App\CatastralTerreno;
use App\TimelineCatastralTerrain;

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

    public function timelineManage() {
        return view('modules.catastral-terreno.timeline.manage');
    }

    public function timelineCreate() {
        $catastralTerrenos = CatastralTerreno::all();
        return view('modules.catastral-terreno.timeline.register', ['catastralTerrenos' => $catastralTerrenos]);
    }

    public function timelineStore(Request $request) {
        $catastralTerreno_id = $request->input('value_catastral_construccion_id');
        $since = $request->input('since');
        $to = $request->input('to');
        $value = $request->input('value');
        $timeline = new TimelineCatastralTerrain();
        $timeline->since = $since;
        $timeline->to = $to;
        $timeline->value = $value;
        $timeline->value_catastral_construccion_id = $catastralConstruccion_id;
        $timeline->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Se ha registrado un valor en la linea de tiempo del valor catastral de construcción.'
        ]);
    }

    public function timelineIndex() {
        $timelines = TimelineCatastralTerrain::all();

//        dd($timelines);
        return view('modules.catastral-terreno.timeline.read', ['timelines' => $timelines]);
    }

    public function timelineShow($id) {
        $catastralTerrenos = CatastralTerreno::all();
        $timeline = TimelineCatastralTerrain::findOrFail($id);
        return view('modules.catastral-terreno.timeline.details', ['timeline' => $timeline, 'catastralTerrenos' => $catastralTerrenos]);
    }

    public function timelineUpdate(Request $request) {
        $id = $request->input('id');
        $since = $request->input('since');
        $to = $request->input('to');
        $valueBuiltTerrain = $request->input('value_built_terrain');
        $valueEmptyTerrain = $request->input('value_empty_terrain');
        $timeline = TimelineCatastralTerrain::find($id);
        $timeline->since = $since;
        $timeline->to = $to;
        $timeline->value_built_terrain = $valueBuiltTerrain;
        $timeline->value_empty_terrain = $valueEmptyTerrain;
        $timeline->update();
        $id = $timeline->id;
        return response()->json([
            'status' => 'success',
            'message' => 'Se ha actualizado un valor en la linea de tiempo del valor catastral de terreno.',
            'id' => $id
        ]);
    }
}
