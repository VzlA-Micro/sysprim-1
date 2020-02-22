<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Alicuota;
use App\TimelineAlicuota;
use Carbon\Carbon;


class AlicuotaController extends Controller
{
    public function manage() {
        return view('modules.alicuota.manage');
    }

    public function show() {
        $alicuotas = Alicuota::all();
        return view('modules.alicuota.read', ['alicuotas' => $alicuotas]);

    }

    public function details($id) {
        $alicuota =Alicuota::find($id);
//        dd($alicuota->timelineValue[0]->value);
        return view('modules.alicuota.details', ['alicuota' => $alicuota]);
    }

    public function update(Request $request) {
        $id = $request->input('id');
        $alicuota = Alicuota::find($id);
        $alicuota->name = $request->input('name');
//        $alicuota->value = $request->input('value')/100;
        $alicuota->update();
    }

    public function timelineManage() {
        return view('modules.alicuota.timeline.manage');
    }

    public function timelineCreate() {
        $alicuotas = Alicuota::orderBy('name','asc')->get();
        return view('modules.alicuota.timeline.register', ['alicuotas' => $alicuotas]);
    }

    public function timelineStore(Request $request) {
        $alicuota_id = $request->input('alicuota_inmueble_id');
        $sinceFormat = Carbon::parse($request->input('since'));
        $since = Carbon::parse($request->input('since'));
        $value = ($request->input('value') / 100);
//        $to = $request->input('to');
        $timeline = TimelineAlicuota::where('alicuota_inmueble_id',(int)$alicuota_id)->whereYear('since', '=',$sinceFormat->format('Y'))->get();
        if($timeline->isEmpty()) {
            $timeline = new TimelineAlicuota();
            $timeline->since = $since;
            $timeline->to = $sinceFormat->format('Y').'-12-31';
            $timeline->value = $value;
            $timeline->alicuota_inmueble_id = $alicuota_id;
            $timeline->save();
            $response = [
                'status' => 'success',
                'message' => 'Se ha registrado un valor en la linea de tiempo de la alicuota.'
            ];
        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Ya existe una linea del tiempo en este rango de fecha asociadas a esta alicuota'
            ];
        }
        return response()->json($response);
    }

    public function timelineShow($id) {
        $alicuotas = Alicuota::orderBy('name','asc')->get();
        $timeline = TimelineAlicuota::findOrFail($id);
        return view('modules.alicuota.timeline.details', ['timeline' => $timeline, 'alicuotas' => $alicuotas]);
    }

    public function timelineIndex() {
        $timelines = TimelineAlicuota::all();
        return view('modules.alicuota.timeline.read', ['timelines' => $timelines]);
    }

    public function timelineUpdate(Request $request) {
        $id = $request->input('id');
        $alicuota_id = $request->input('alicuota_inmueble_id');
        $sinceFormat = Carbon::parse($request->input('since'));
        $since = Carbon::parse($request->input('since'));
//        $to = $request->input('to');
        $value = ($request->input('value') / 100);
        $verifiedTimeline = $this->verifiedTimelineUpdate($id, $sinceFormat->format('Y'), $alicuota_id);

        if ($verifiedTimeline['response']) {
            $timeline = TimelineAlicuota::findOrFail($id);
            $timeline->since = $since;
            $timeline->to = $sinceFormat->format('Y').'-12-31';
            $timeline->value = $value;
            $timeline->update();
            $id = $timeline->id;
            $response = [
                'status' => 'success',
                'message' => 'Se ha actualizado un valor en la linea de tiempo de la alicuota.',
                'id' => $id
            ];
        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Ya existe una linea del tiempo en este rango de fecha asociadas a esta alicuota'
            ];
        }
        /*$timeline = TimelineAlicuota::find($id);
        $timeline->since = $since;
        $timeline->to = $sinceFormat->format('Y').'-12-31';
        $timeline->value = $value;
        $timeline->update();
        $id = $timeline->id;*/
        return response()->json($response);
    }

    public function verifiedTimelineUpdate($idTimeline, $since, $id)
    {
        $timelines = TimelineAlicuota::where('id', (int)$idTimeline)
            ->whereYear('since', '=', $since)->get();

        $respon='';

        if (!$timelines->isEmpty()) {
            $update = true;
        } else {
            $update = false;
        }

        $timeline = TimelineAlicuota::where('alicuota_inmueble_id', $id)
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
