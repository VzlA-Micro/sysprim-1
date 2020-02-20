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
        $alicuotas = Alicuota::all();
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
        $alicuotas = Alicuota::all();
        $timeline = TimelineAlicuota::findOrFail($id);
        return view('modules.alicuota.timeline.details', ['timeline' => $timeline, 'alicuotas' => $alicuotas]);
    }

    public function timelineIndex() {
        $timelines = TimelineAlicuota::all();
        return view('modules.alicuota.timeline.read', ['timelines' => $timelines]);
    }

    public function timelineUpdate(Request $request) {
        $id = $request->input('id');
        $since = $request->input('since');
        $to = $request->input('to');
        $value = ($request->input('value') / 100);
        $timeline = TimelineAlicuota::find($id);
        $timeline->since = $since;
        $timeline->to = $to;
        $timeline->value = $value;
        $timeline->update();
        $id = $timeline->id;
        return response()->json([
            'status' => 'success',
            'message' => 'Se ha actualizado un valor en la linea de tiempo de la alicuota.',
            'id' => $id
        ]);
    }
}
