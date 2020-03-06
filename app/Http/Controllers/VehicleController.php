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
use App\Helpers\Trimester;


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
    public function create($register = null)
    {
        $models = ModelsVehicle::all();
        $brands = Brand::all();
        $type = VehicleType::all();

        $vehicleCompa = explode('-', $register);


        if ($vehicleCompa[0] === "COMPANY") {
            $company = Company::find($vehicleCompa[1]);
            return view('modules.vehicles.register', array(
                'brand' => $brands,
                'model' => $models,
                'type' => $type,
                'idCompany' => $vehicleCompa[1],
                'company' => $company->name
            ));
        }

        if ($register == 0) {

            return view('modules.vehicles.registerr', array(
                'brand' => $brands,
                'model' => $models,
                'type' => $type
            ));
        }
        if (!$register) {

        } else {
            return view('modules.ticket-office.vehicle.modules.vehicle.register', array(
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

        $vehicle->license_plate = strtoupper($request->input('license_plate'));
        $vehicle->color = strtoupper($request->input('color'));
        $bodySerial = strtoupper($request->input('bodySerial'));

        $vehicle->serial_engine = strtoupper($request->input('serialEngine'));
        $vehicle->type_vehicle_id = $request->input('typeV');
        $vehicle->status = 'enabled';

        $idCompany = $request->input('idCompany');


        if (!empty($request->input('brand-n') && !empty($request->input('model-n')))) {

            $brandVehicles = new Brand();
            $modelsVehicle = new ModelsVehicle();

            $models = strtoupper($request->input('model-n'));
            $brand = strtoupper($request->input('brand-n'));
            $otherBrand = Brand::where('name', $brand)->first();

            if (is_object($otherBrand)) {
                $modelsVehicle->name = $models;
                $modelsVehicle->brand_id = $otherBrand->id;
                $modelsVehicle->save();

                $vehicle->model_id = $modelsVehicle->id;

            } else {
                $brandVehicles->name = $brand;
                $brandVehicles->save();

                $modelsVehicle->name = $models;
                $modelsVehicle->brand_id = $brandVehicles->id;
                $modelsVehicle->save();

                $vehicle->model_id = $modelsVehicle->id;
            }

        } else {
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

        $vehicle->body_serial = $bodySerial;

        $vehicle->save();

        $owner_id = $request->input('idUser');


        $status = $request->input('status');
        $userVehicle = new UserVehicle();

        if ($status == "propietario") {
            if (isset($idCompany)) {
                $userVehicle->user_id = \Auth::user()->id;
                $userVehicle->vehicle_id = $vehicle->id;
                $userVehicle->person_id = null;
                $userVehicle->company_id = $idCompany;
                $userVehicle->status_user_vehicle = $request->input('status');
            } else {
                $userVehicle->user_id = \Auth::user()->id;
                $userVehicle->vehicle_id = $vehicle->id;
                $userVehicle->person_id = \Auth::user()->id;
                $userVehicle->company_id = null;
                $userVehicle->status_user_vehicle = $request->input('status');
            }

        } else {
            $userVehicle->user_id = \Auth::user()->id;
            $userVehicle->vehicle_id = $vehicle->id;
            $userVehicle->person_id = $owner_id;
            $userVehicle->company_id = null;
            $userVehicle->status_user_vehicle = $request->input('status');

        }

        $userVehicle->save();
        if ($vehicle->save() && $userVehicle->save() && isset($idCompany)) {
            $response = ['status' => 'success', 'isCompany' => true];
        } else if ($vehicle->save() && $userVehicle->save()) {
            $response = ['status' => 'success', 'isCompany' => false];
        } else {
            $response = ['status' => 'fail'];
        }

        return response()->json($response);
    }

    /*public function store(Request $request)
    {

        $license_plate = strtoupper($request->input('license_plate'));
        $color = $request->input('color');
        $body_serial = $request->input('bodySerial');
        $serial_engine = $request->input('serialEngine');
        $type_vehicle_id = (int)$request->input('typeV');
        $status = 'enabled';
        $personId=(int)$request->input('idUser');
        $image = $request->file('image');
        $year=(int)$request->input('year');

        $vehicle= new Vehicle();

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
            $vehicle->model_id =intval($request->input('model'));
        }

        $vehicle->license_plate = $license_plate;
        $vehicle->color = $color;
        $vehicle->body_serial = $body_serial;
        $vehicle->serial_engine = $serial_engine;
        $vehicle->type_vehicle_id = $type_vehicle_id;
        $vehicle->status = $status;

        $vehicle->year = $year;


        if ($image) {
            $image_path_name = time() . $image->getClientOriginalName();
            Storage::disk('vehicles')->put($image_path_name, File::get($image));
            $vehicle->image = $image_path_name;
        } else {
            $vehicle->image = null;
        }

        $vehicle->save();
        if ($vehicle->save()){
            $vRegister=true;
        }else{
            $vRegister=false;
        }


        $userVehicle = new UserVehicle();

        if ($status=="propietario") {
            $userVehicle->user_id = \Auth::user()->id;
            $userVehicle->vehicle_id = $vehicle->id;
            $userVehicle->person_id=\Auth::user()->id;
            $userVehicle->company_id=null;
            $userVehicle->status_user_vehicle = $request->input('status');
        } else {
            $userVehicle->user_id = \Auth::user()->id;
            $userVehicle->vehicle_id = $vehicle->id;
            $userVehicle->person_id=$personId;
            $userVehicle->company_id=null;
            $userVehicle->status_user_vehicle = $request->input('status');
        }

        if ($userVehicle->save()){
            $uvRegister=true;
        }else{
            $uvRegister=false;
        }

        if ($vRegister && $uvRegister){
            $response=['status'=>'success','message'=>'Has registrado el vehículo Con Exito'];
        }else{
            $response=['status'=>'fail'];
        }


       return response()->json($response);
    }/*

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $vehicle = \Auth::user()->vehicles()->with('company')->get();
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
        $value = explode('-', $id);
        $idVehicle = $value[0];
        $vehicle = Vehicle::where('id', $idVehicle)->with('company')->get();
        if (isset($value[1])) {
            $valor = $value[1];
        } else {
            $valor = false;
        }

        if ($valor) {
            $response = 'company';
        } else {
            $response = 'vehicle';
        }

//        dd($vehicle[0]->model);

        return view('modules.vehicles.details', array(
            'vehicle' => $vehicle,
            'status' => $response
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

        $id = $request->input('id');
        $licensePlate = $request->input('license');
        $color = strtoupper($request->input('color'));
        $body_serial = $request->input('bodySerial');
        $serial_engine = $request->input('serialEngine');
        $type_vehicle_id = $request->input('type');
        $year = $request->input('year');
        $models = $request->input('model');
        //$brand = $request->input('brand');
        $vehicle = Vehicle::find($id);
        $vehicle->license_plate = $licensePlate;
        $vehicle->color = $color;
        $vehicle->body_serial = $body_serial;
        $vehicle->serial_engine = $serial_engine;
        $vehicle->type_vehicle_id = $type_vehicle_id;
        $vehicle->year = $year;
        $vehicle->model_id = $models;

        $vehicle->update();

        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function brand(Request $request)
    {
        $models = ModelsVehicle::where('brand_id', $request->input('brand'))->get();
        return response()->json([$models]);
    }


    public function licensePlate(Request $request)
    {
        $id = null;
        if ($request->input('id') != null) {
            $id = $request->input('id');
        }
        $licencia = strtoupper($request->input('license'));

        if (is_null($id)) {
            $license = Vehicle::where('license_plate', $licencia)->get();
        } else {
            $license = Vehicle::where('license_plate', $licencia)
                ->where('id', '!=', $id)->get();

        }

        if (!$license->isEmpty()) {

            $response = array('status' => 'error', 'message' => 'La Placa "' . $request->input('license') . '" se encuentra registrada en el sistema. Por favor, ingrese una placa valida.');

        } else {
            $response = array('status' => 'success', 'message' => 'No registrada.');
        }


        return response()->json($response);

    }


    public function serialEngine(Request $request)
    {
        $id = null;
        if ($request->input('id') != null) {
            $id = $request->input('id');
        }

        if (is_null($id)) {
            $serialEngine = Vehicle::where('serial_engine', $request->input('serialEngine'))->get();
        } else {
            $serialEngine = Vehicle::where('serial_engine', $request->input('serialEngine'))
                ->where('id', '!=', $id)->get();
        }
        if (!$serialEngine->isEmpty()) {
            $response = array('status' => 'error', 'message' => 'El serial del motor "' . $request->input('serialEngine') . '" se encuentra registrado en el sistema. Por favor, ingrese un serial válido.');
        } else {
            $response = array('status' => 'success', 'message' => 'No registrado.');
        }

        return response()->json($response);

    }


    public function bodySerial(Request $request)
    {
        $id = null;
        if ($request->input('id') != null) {
            $id = $request->input('id');
        }

        if (is_null($id)) {
            $bodySerial = Vehicle::where('body_serial', $request->input('bodySerial'))->get();
        } else {

            $bodySerial = Vehicle::where('body_serial', $request->input('bodySerial'))
                ->where('id', '!=', $id)->get();

        }
        if (!$bodySerial->isEmpty()) {
            $response = array('status' => 'error', 'message' => 'El serial de la carrocería "' . $request->input('bodySerial') . '" se encuentra registrado en el sistema. Por favor, ingrese un serial de carrocería válido.');
        } else {
            $response = array('status' => 'success', 'message' => 'No registrado.');
        }

        return response()->json($response);

    }

    public function getImage($filename)
    {
        $file = Storage::disk('vehicles')->get($filename);
        return new Response($file, 200);
    }

    public function showTicketOffice()
    {
        $vehicle = Vehicle::orderBy('id','desc')->get();
        return view('modules.ticket-office.vehicle.modules.vehicle.read', array(
            'show' => $vehicle
        ));
    }

    public function searchLicensePlate($license)
    {
        //$license = $request->input('licensePlate');

        $vehicle = Vehicle::where('license_plate', $license)->with('users')->with('model')->get();
        $modelVehicle = Vehicle::where('license_plate', $license)->get();

        if (!$vehicle->isEmpty()) {
            $response = array(
                "status" => "notEmpty",
                "message" => "",
                "vehicle" => $vehicle,
                "modelVehicle" => $modelVehicle[0]->model->brand->name,
                "userVehicle" => $modelVehicle[0]->users
            );
        } else {
            $response = array(
                "status" => "empty",
                "message" => "Placa no encontrada"
            );
        }

        return Response()->json($response);

    }

    public function periodoFiscal($period)
    {
        $trimester = Trimester::verifyTrimester();
        //si es TRUE es trimestral
        if ($period == 1) {
            $trimestre = $trimester['trimesterBegin'] . " - " . $trimester['trimesterEnd'];
            $response = array(
                "trimestre" => $trimestre,
                "status" => "trimestre"
            );
        } else {
            //ES FALSE POR LO TANTO ES ANUAL
            $year = $trimester['current']->format('m-Y') . " - " . "12-" . $trimester['current']->format('Y');
            $response = array(
                "year" => $year,
                "status" => "year"
            );
        }

        return response()->json($response);
    }

    public function manage($id)
    {
        $value = explode('-', $id);
        $idVehicle = $value[0];
        if (isset($value[1])) {
            $idCompany = $value[1];
        } else {
            $idCompany = false;
        }
        $vehicle = Vehicle::where('id', $idVehicle)->with('company')->get();

        if ($idCompany) {
            $response = 'company';
        } else {
            $response = 'vehicle';
        }
        return view('modules.vehicles.manage', [
            'id' => $idVehicle,
            'idCompany' => $idCompany,
            'status' => $response,
            'vehicle' => $vehicle
        ]);
    }

    public function vehicleCompanyRead($idCompany)
    {
        $companyVehicle = Company::where('id', $idCompany)->with('vehicles')->get();
        session('company', $companyVehicle[0]->name);
        return view('modules.vehicles.menu', array(
            'show' => $companyVehicle[0]->vehicles,
            'company' => $companyVehicle[0]
        ));
    }

    public function findTaxpayersCompany($type_document, $document)
    {
        if ($type_document == 'V' || $type_document == 'E') {
            $user = User::where('ci', $type_document . $document)->get();
            if ($user->isEmpty()) {
                $user = CedulaVE::get($type_document, $document, false);
                $data = ['status' => 'success', 'type' => 'not-user', 'user' => $user];
            } else {
                $data = ['status' => 'success', 'type' => 'user', 'user' => $user[0]];
            }
        } else {
            $company = Company::where('RIF', $type_document . $document)->get();

            if ($company->isEmpty()) {
                $data = ['status' => 'error', 'type' => 'not-company', 'company' => null];
            } else {
                $data = ['status' => 'success', 'type' => 'company', 'company' => $company[0]];
            }
        }
        return response()->json($data);
    }


}
