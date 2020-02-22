<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use Mail;
use App\Company;
use App\Helpers\TaxesMonth;
use App\Http\Controllers\Controller;
use App\Payments;
use Carbon\Carbon;
use App\Vehicle;
use App\Brand;
use App\Models;
use App\VehicleType;

class VehicleTypeController extends Controller
{
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type= new VehicleType();
        $type->name= $request->input('type_vehicle');
        //$type->rate= $request->input('rate');
        //$type->rate_UT= $request->input('rate_ut');
        $type->save();

        return redirect()->route('type-vehicles.read');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $type= VehicleType::orderBy('id','desc')->get();
        return view('modules.vehicle_type.read',array(
            'showType'=>$type
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
        $type= VehicleType::find($id);
        return view('modules.vehicle_type.details',array(
            'type'=>$type
        ));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //$id=$request->input('id');
        $type=VehicleType::findOrFail($request->input('id'));
        $type->name= $request->input('name');
        //$type->rate= $request->input('rate');
        //$type->rate_UT= $request->input('rate_ut');
        $type->update();
        $update=true;
        return response()->json(['update'=>$update]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type=VehicleType::destroy($id);
        return redirect()->route('type-vehicles.read');
    }
}
