<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CatastralConstruccion;
use App\TimelineCatastralBuild;
use Carbon\Carbon;



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
        $catastralConstrucciones = CatastralConstruccion::orderBy('name','asc')->get();
        return view('modules.catastral-construction.timeline.register', ['catastralConstrucciones' => $catastralConstrucciones]);
    }

    public function timelineStore(Request $request) {
        $catastralConstruccion_id = $request->input('value_catastral_construccion_id');
        $sinceFormat = Carbon::parse($request->input('since'));
        $since = Carbon::parse($request->input('since'));
//        $to = $request->input('to');
        $value = $request->input('value');
        $timeline = TimelineCatastralBuild::where('value_catastral_construccion_id',(int)$catastralConstruccion_id)->whereYear('since', '=',$sinceFormat->format('Y'))->get();


        if($timeline->isEmpty()) {
            $timeline = new TimelineCatastralBuild();
            $timeline->since = $since;
            $timeline->to = $sinceFormat->format('Y').'-12-31';
            $timeline->value = $value;
            $timeline->value_catastral_construccion_id = $catastralConstruccion_id;
            $timeline->save();
            $response = [
                'status' => 'success',
                'message' => 'Se ha registrado un valor en la linea de tiempo del valor catastral de construcción.'
            ];
        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Ya existe una linea del tiempo en este rango de fecha asociadas a este valor catastral de construcción'
            ];
        }
        return response()->json($response);
    }

    public function timelineIndex() {
        $timelines = TimelineCatastralBuild::all();
        return view('modules.catastral-construction.timeline.read', ['timelines' => $timelines]);
    }

    public function timelineShow($id) {
        $catastralConstrucciones = CatastralConstruccion::orderBy('name','asc')->get();
        $timeline = TimelineCatastralBuild::findOrFail($id);
        return view('modules.catastral-construction.timeline.details', ['timeline' => $timeline, 'catastralConstrucciones' => $catastralConstrucciones]);
    }

    public function timelineUpdate(Request $request) {
        $id = $request->input('id');
        $catastralConstruccion_id = $request->input('value_catastral_construccion_id');
        $sinceFormat = Carbon::parse($request->input('since'));
        $since = Carbon::parse($request->input('since'));
        $value = $request->input('value');

        $verifiedTimeline = $this->verifiedTimelineUpdate($id, $sinceFormat->format('Y'), $catastralConstruccion_id);

        //$timeline = TimelineCatastralBuild::where('value_catastral_construccion_id',(int)$catastralConstruccion_id)->whereYear('since', '=',$sinceFormat->format('Y'))->get();
        if ($verifiedTimeline['response']) {
            $timeline = TimelineCatastralBuild::findOrFail($id);
            $timeline->since = $since;
            $timeline->to = $sinceFormat->format('Y').'-12-31';
            $timeline->value = $value;
            $timeline->update();
            $id = $timeline->id;
            $response = [
                'status' => 'success',
                'message' => 'Se ha actualizado un valor en la linea de tiempo del valor catastral de construcción.',
                'id' => $id
            ];
        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Ya existe una linea del tiempo en este rango de fecha asociadas a este valor catastral de construcción.'
            ];
        }
        return response()->json($response);
    }

    public function verifiedTimelineUpdate($idTimeline, $since, $id)
    {
        $timelines = TimelineCatastralBuild::where('id', (int)$idTimeline)
            ->whereYear('since', '=', $since)->get();

        $respon='';

        if (!$timelines->isEmpty()) {
            $update = true;
        } else {
            $update = false;
        }

        $timeline = TimelineCatastralBuild::where('value_catastral_construccion_id', $id)
            ->whereYear('since', '<=', (string)$since)
            ->whereYear('to', '>=', (string)$since)->get();

        if (!$timeline->isEmpty()) {
            $updateSince =true;
        } else {
            $updateSince =false;
        }

        if ($update==false && $updateSince==true){
            //NO PUEDE ACTUALIZAR, PORQUE YA EXISTE UN REGISTRO CON ESA FECHA
            $response=false;
        }elseif ($update==false && $updateSince==false){
            //PUEDE ACTUALIZAR
            $response=true;
        }elseif ($update==true && $updateSince==true){
            //PUEDE ACTUALIZAR
            $response=true;
        }

        $respon=[
            'response'=>$response
        ];

        return $respon;
    }
}
