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
        $timeline=TimelineTypeVehicle::orderBy('id','desc')->get();
        //dd($timeline[0]->type);

        return view('modules.vehicle_type.time-line.read',array(
            'timeline'=>$timeline
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type=VehicleType::all();
        return view('modules.vehicle_type.time-line.register',array(
            'type'=>$type
        ));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $timeLine= new TimelineTypeVehicle();
        $timeLine->type_vehicle_id=$request->input('type_vehicle');
        $timeLine->rate= $request->input('rate');
        $timeLine->rate_UT= $request->input('rate_ut');
        $timeLine->since = $request->input('date_start');
        $timeLine->to= $request->input('date_end');

        $timeLine->save();

        $response=null;

        if ($timeLine->save()){
            $response=array(
                'status'=>true,
                'message'=>'Linea del tiempo ha sido registrada exitosamente'
            );
        }else{
            $response=array(
                'status'=>false,
                'message'=>'Linea del tiempo no se ha podido registrar'
            );
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $timeline=TimelineTypeVehicle::find($id);
        return view('modules.vehicle_type.time-line.details',array(
            'timeline'=>$timeline
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
