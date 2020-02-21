<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\VehicleType;
use App\TimelineTypeVehicle;


class TimelineTypeVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timeline = TimelineTypeVehicle::orderBy('id', 'desc')->get();
        //dd($timeline[0]->type);

        return view('modules.vehicle_type.time-line.read', array(
            'timeline' => $timeline
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = VehicleType::all();
        return view('modules.vehicle_type.time-line.register', array(
            'type' => $type
        ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $typeVehicle = $request->input('type_vehicle');
        $since = Carbon::parse($request->input('since'));
        $to = $since->format('Y') . '-12-' . '31';
        $response = false;
        $verifiedTimeline = $this->verifiedTimeline($typeVehicle, $since);

        if ($verifiedTimeline) {
            $response = array(
                'status' => 'validation-failed',
                'message' => 'Esta linea de tiempo ya posee un registro con este año'
            );
            return response()->json($response);
        } else {

            $timeLine = new TimelineTypeVehicle();
            $timeLine->type_vehicle_id = $typeVehicle;
            $timeLine->rate = $request->input('rate');
            $timeLine->rate_UT = $request->input('rate_ut');
            $timeLine->since = $since->format('Y-m-d');
            $timeLine->to = $to;

            $timeLine->save();


            if ($timeLine->save()) {
                $response = array(
                    'status' => true,
                    'message' => 'Linea del tiempo ha sido registrada exitosamente'
                );
            } else {
                $response = array(
                    'status' => false,
                    'message' => 'Linea del tiempo no se ha podido registrar'
                );
            }

            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timeline = TimelineTypeVehicle::find($id);
        return view('modules.vehicle_type.time-line.details', array(
            'timeline' => $timeline
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $typeVehicle = $request->input('typeVehicleId');
        $timeLineId = $request->input('id');

        $since = Carbon::parse($request->input('date_start'));
        $to = $since->format('Y') . '-12-' . '31';

        $response = false;

        $verifiedTimeline = $this->verifiedTimelineUpdate($timeLineId, $since->format('Y'), $typeVehicle);

        if ($verifiedTimeline) {
            $timeLine = TimelineTypeVehicle::find($request->input('id'));
            $timeLine->rate = $request->input('rate');
            $timeLine->rate_UT = $request->input('rate_ut');
            $timeLine->since = $since;
            $timeLine->to = $to;

            $timeLine->update();

            if ($timeLine->update()) {
                $response = [
                    'status' => true,
                    'message' => 'Se ha actualizado el registro exitosamente'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'No se ha podido actualizar'
                ];
            }
        } else {
            $response = array(
                'status' => 'validation-failed',
                'message' => 'Esta linea de tiempo ya posee un registro con este año'
            );
        }

        return response()->json($response);
    }



    public function verifiedTimeline($TypeVehicleId, $since)
    {
        $response = 0;

        $timeline = TimelineTypeVehicle::where('type_vehicle_id', (int)$TypeVehicleId)
            ->whereYear('since', '=', (string)$since)->get();

        if ($timeline->isEmpty()) {
            $response = false;
        } else {
            $response = true;
        }

        return $response;
    }

    public function verifiedTimelineUpdate($idTimeline, $since, $typeVehicleId)
    {
        $timelines = TimelineTypeVehicle::where('id', (int)$idTimeline)
            ->whereYear('since', '=', $since)->get();

        if (!$timelines->isEmpty()) {
            $update = ['status'=>true];
        } else {
            $update = ['status'=>false];
        }

        $timeline = TimelineTypeVehicle::where('type_vehicle_id', $typeVehicleId)
            ->whereYear('since', '<=', (string)$since)
            ->whereYear('to', '>=', (string)$since)->get();

        if (!$timeline->isEmpty()) {
            $updateSince =['status'=>true];
        } else {
            $updateSince = ['status'=>false];
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
