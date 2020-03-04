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
use App\ModelsVehicle;
use App\VehicleType;

class ModelsVehicleController extends Controller
{
    //

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
        $brands=Brand::all();
        return view('modules.vehicles_models.register',array(
            'brand'=>$brands,
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
        $models= new ModelsVehicle();
        $models->name= strtoupper($request->input('models'));
        $models->brand_id= $request->input('brand');
        $models->save();

        return redirect()->route('vehicles.models.read');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $models= ModelsVehicle::orderby('id','desc')->get();
        return view('modules.vehicles_models.read',array(
            'showModels'=>$models
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
        $models= ModelsVehicle::findOrFail($id);
        $brand=Brand::all();
        return view('modules.vehicles_models.details',array(
            'models'=>$models,
            'brands'=>$brand
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
        $models=ModelsVehicle::findOrFail($request->input('id'));
        $models->name= strtoupper($request->input('name'));
        $models->brand_id= $request->input('brand');
        $models->update();
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
