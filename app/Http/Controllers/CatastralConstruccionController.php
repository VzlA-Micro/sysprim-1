<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CatastralConstruccion;
use App\TimelineCatastralBuild;


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
        $catastral->status = $request->input('status');
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
        $catastral->status = $request->input('status');
        $catastral->regimen_horizontal =$request->input('regimen_horizontal');
        $catastral->update();
        return response()->json(['status'=>'success'],200);
    }

    public function timelineManage() {
        return view('modules.catastral-construction.timeline.manage');
    }

    public function timelineCreate() {
        $catastralConstrucciones = CatastralConstruccion::all();
        return view('modules.catastral-construction.timeline.register', ['catastralConstrucciones' => $catastralConstrucciones]);
    }

    public function timelineStore(Request $request) {
        $catastralConstruccion_id = $request->input('value_catastral_construccion_id');
        $since = $request->input('since');
        $to = $request->input('to');
        $value = $request->input('value');
        $timeline = new TimelineCatastralBuild();
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
        $timelines = TimelineCatastralBuild::all();
        return view('modules.catastral-construction.timeline.read', ['timelines' => $timelines]);
    }

    public function timelineShow($id) {
        $catastralConstrucciones = CatastralConstruccion::all();
        $timeline = TimelineCatastralBuild::findOrFail($id);
        return view('modules.catastral-construction.timeline.details', ['timeline' => $timeline, 'catastralConstrucciones' => $catastralConstrucciones]);
    }

    public function timelineUpdate(Request $request) {
        $id = $request->input('id');
        $since = $request->input('since');
        $to = $request->input('to');
        $value = $request->input('value');
        $timeline = TimelineCatastralBuild::find($id);
        $timeline->since = $since;
        $timeline->to = $to;
        $timeline->value = $value;
        $timeline->update();
        $id = $timeline->id;
        return response()->json([
            'status' => 'success',
            'message' => 'Se ha actualizado un valor en la linea de tiempo del valor catastral de construcción.',
            'id' => $id
        ]);
    }
}
