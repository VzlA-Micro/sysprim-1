<?php

namespace App\Http\Controllers;

use App\models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;
use Mail;
use App\Company;
use App\Helpers\TaxesMonth;
use App\Http\Controllers\Controller;
use App\Payments;
use Carbon\Carbon;
use App\Vehicle;
use App\UserVehicle;
use App\Brand;
use App\ModelsVehicle;
use App\VehicleType;

class VehicleController extends Controller
{
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($register=0)
    {
        $models = ModelsVehicle::all();
        $brands = Brand::all();
        $type = VehicleType::all();

        if (!$register) {

        } else {
            return view('modules.ticket-office.vehicle.modules.vehicle.register', array(
                'brand' => $brands,
                'model' => $models,
                'type' => $type
            ));
        }

        if ($register==0){
            return view('modules.vehicles.register', array(
                'brand' => $brands,
                'model' => $models,
                'type' => $type
            ));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle = new Vehicle();
        $vehicle->license_plate = $request->input('license_plate');
        $vehicle->color = $request->input('color');
        $vehicle->body_serial = $request->input('bodySerial');
        $vehicle->serial_engine = $request->input('serialEngine');
        $vehicle->type_vehicle_id = $request->input('type');
        $vehicle->status='enabled';
        if (!empty($request->input('brand-n') && $request->input('model-n'))) {

            $brandVehicles = new Brand();

            $modelsVehicle = new ModelsVehicle();

            $models = strtoupper($request->input('model-n'));
            $brand = strtoupper($request->input('brand-n'));
            $otherBrand = Brand::where('name', $brand)->exists();

            if ($otherBrand) {

            } else {
                $brandVehicles->name = $brand;
                $brandVehicles->save();

                $modelsVehicle->name = $models;
                $modelsVehicle->brand_id = $brandVehicles->id;
                $modelsVehicle->save();

                $vehicle->model_id = $modelsVehicle->id;
            }

        } else {
            $models = $request->input('models');
            $brand = $request->input('brand');
            $vehicle->model_id = $request->input('model');
        }


        //$vehicle->model_id = $request->input('model');
        $vehicle->year = $request->input('year');
        $image = $request->file('image');


        if ($image) {
            $image_path_name = time() . $image->getClientOriginalName();
            Storage::disk('vehicles')->put($image_path_name, File::get($image));
            $vehicle->image = $image_path_name;
        } else {
            $vehicle->image = null;
        }
        $vehicle->save();

        $userVehicle = new UserVehicle();

        $userVehicle->user_id = \Auth::user()->id;
        $userVehicle->vehicle_id = $vehicle->id;
        $userVehicle->status_user_vehicle = $request->input('status');
        $userVehicle->save();

        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        $vehicle = \Auth::user()->vehicles()->get();


        return view('modules.vehicles.menu', array(
            'show' => $vehicle
        ));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        if (session()->has('vehicle')) {
            session()->forget(['vehicle']);
            session()->put('vehicle', $vehicle->id);
        } else {
            session()->put('vehicle', $vehicle->id);
        }


        return view('modules.vehicles.details', array(
            'vehicle' => $vehicle
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
        //$id=$request->input('id');
        var_dump($request->input('groupCiuId'));
        $ciu = ciu::findOrFail($request->input('id'));
        $ciu->code = $request->input('code');
        $ciu->name = $request->input('name');
        $ciu->alicuota = $request->input('alicuota');
        $ciu->min_tribu_men = $request->input('mTM');
        $ciu->group_ciu_id = $request->input('idGroupCiiu');

        $ciu->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ciu = ciu::destroy($id);
        return redirect()->route('ciu-branch.read');
    }


    public function brand(Request $request)
    {
        $models = ModelsVehicle::where('brand_id', $request->input('brand'))->get();
        $count = count($models);

        return response()->json([$models, $count]);
    }


    public function licensePlate(Request $request)
    {
        $license = Vehicle::where('license_plate', $request->input('license'))->exists();
        return response()->json($license);
    }


    public function serialEngine(Request $request)
    {
        $serialEngine = Vehicle::where('serial_engine', $request->input('serialEngine'))->exists();
        return response()->json($serialEngine);
    }


    public function bodySerial(Request $request)
    {
        $bodySerial = Vehicle::where('body_serial', $request->input('bodySerial'))->exists();
        return response()->json($bodySerial);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('vehicles')->get($filename);
        return new Response($file, 200);
    }

    public function showTicketOffice()
    {
        $vehicle = Vehicle::all();
        return view('modules.ticket-office.vehicle.modules.vehicle.read', array(
            'show' => $vehicle
        ));
    }


}
