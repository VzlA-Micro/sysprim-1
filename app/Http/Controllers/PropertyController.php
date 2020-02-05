<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parish;
use App\CatastralTerreno;
use App\Inmueble;
use App\UserProperty;
use App\Val_cat_const_inmu;
use Illuminate\Support\Facades\DB;
//use PhpParser\Builder\Property;
use App\CatastralConstruccion;
use App\Alicuota;
use App\Property;
use App\Company;
use App\User;

class PropertyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userProperties = UserProperty::where('user_id', \Auth::user()->id)->select('property_id')->get();
        $properties = Property::whereIn('id', $userProperties)->get();
        $userProperties = UserProperty::where('user_id', \Auth::user()->id)->get();
//        dd($properties);
        session()->forget('company');
        return view('modules.properties.manage', ['properties' => $properties, 'userProperties' => $userProperties]);
    }


    public function myProperty()
    {
        $userProperty = UserProperty::where('user_id', \Auth::user()->id)->select('property_id')->get();
        $property = Property::whereIn('id', $userProperty)->get();
        return view('modules.properties-payments.manage', ['property' => $property]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_id = "")
    {
//        dd($company); die();
        if($company_id != '') {
            $company = Company::find($company_id);
        }
        else{
            $company = '';
        }
        $catastralTerre = CatastralTerreno::all();
        $catastralConst = CatastralConstruccion::all();
        $parish = Parish::all();
        $alicuota= Alicuota::all();
        return view('modules.properties.register', [
            'parish' => $parish,
            'catasTerreno' => $catastralTerre,
            'catasConstruccion' => $catastralConst,
            'alicuota'=>$alicuota,
            'company' => $company
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type=$request->input('type');
        $code_cadastral =
            $request->input('C1') .
            '-' . $request->input('C2') .
            '-' . $request->input('C3') .
            '-' . $request->input('C4') .
            '-' . $request->input('C5') .
            '-' . $request->input('C6') .
            '-' . $request->input('C7') .
            '-' . $request->input('C8');

        $location_cadastral = $request->input('location_cadastral');
        $area_build = $request->input('area_build');
        $area_ground = $request->input('area_ground');
        $parish = $request->input('parish');
        $address = $request->input('address');
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $typeConst = $request->input('type_const');
        $type_inmueble_id = $request->input('type_inmueble_id');
        $status = $request->input('status');
//        $type = $request->input('type');
        $owner_id = $request->input('id');

        $property = new Property();
        $property->parish_id = $parish;
        $property->value_cadastral_ground_id = $location_cadastral;
        $property->code_cadastral = $code_cadastral;
        $property->address = $address;
        $property->area_build = $area_build;
        $property->area_ground = $area_ground;
        $property->lat = $lat;
        $property->lng = $lng;
        $property->type_inmueble_id = $type_inmueble_id;
        $property->value_cadastral_build_id = $typeConst;
//        dd($owner_id); die();
        $property->save();

        $id = $property->id; // Obtengo el id del inmueble que registro
        $person_id=null;
        $company_id=null;
        if($status == 'propietario'){
            if($type == 'company'){
                $user_id = \Auth::user()->id;
                $company_id = $owner_id;
            }
            else {
                $person_id = \Auth::user()->id;
                $user_id = \Auth::user()->id;
            }
        }
        else{
            if($type=='user'){
                $user_id = \Auth::user()->id;
                $person_id = $owner_id;
            }
            else {
                $user_id = \Auth::user()->id;
                $company_id = $owner_id;
            }
        }
//        $property->catastralConstruction()->attach(['value_catas_const_id' => $typeConst], ['property_id' => $id]); // Inserto en la tabla puente
        $property->users()->attach(['property_id' => $id], ['user_id' => $user_id, 'status' => $status, 'person_id' => $person_id, 'company_id' => $company_id]);

        /*elseif($status == 'responsable') {
            $property->users()->attach(
                ['property_id' => $id],
                ['user_id' => $user_id],
                ['status' => $status],
                ['person_id' => $owner_id]);
        }*/
        $valCat = new Val_cat_const_inmu();
        $valCat->value_catas_const_id = $typeConst;
        $valCat->property_id = $id;
        $valCat->save();
        return response()->json(['status' => 'success', 'message' => 'El inmueble se ha registrado con éxito.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Inmueble::where('id', $id)->get();
        $pCatasConstruct = Val_cat_const_inmu::where('property_id', $property[0]->id)->select('value_catas_const_id')->get();

        $catasConstruct = CatastralConstruccion::find($pCatasConstruct[0]->value_catas_const_id);

        $catasTerreno = CatastralTerreno::find($property[0]->value_cadastral_ground_id);


        $parish = Parish::find($property[0]->parish_id);
        return view('modules.properties.details', array(
            'property' => $property,
            'catasConstruct' => $catasConstruct,
            'catasTerreno' => $catasTerreno,
            'parish' => $parish
        ));

    }

    public function details($id) {
        $property = Property::where('id', $id)->get();
        $pCatasConstruct = Val_cat_const_inmu::where('property_id', $property[0]->id)->select('value_catas_const_id')->get();
        $catasConstruct = CatastralConstruccion::find($pCatasConstruct[0]->value_catas_const_id);
        $catasTerreno = CatastralTerreno::find($property[0]->value_cadastral_ground_id);

        $parish = Parish::find($property[0]->parish_id);
        return view('modules.properties.details', array(
            'property' => $property,
            'catasConstruct' => $catasConstruct,
            'catasTerreno' => $catasTerreno,
            'parish' => $parish
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
        $property = Inmueble::where('id', $id)->get();

        var_dump($property);
        die();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$id=$request->input('id');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function verification(Request $request)
    {

        $code_cadastral =
            $request->input('C1') .
            '-' . $request->input('C2') .
            '-' . $request->input('C3') .
            '-' . $request->input('C4') .
            '-' . $request->input('C5') .
            '-' . $request->input('C6') .
            '-' . $request->input('C7') .
            '-' . $request->input('C8') .
            '-' . $request->input('C9') .
            '-' . $request->input('C10');
        $property = PropertyTmp::where('code_cadastral', $code_cadastral)->get();
        return response()->json([$property]);
    }

    public function findTaxpayersCompany($type_document,$document){
        if($type_document=='V'||$type_document=='E'){
            $user = User::where('ci', $type_document.$document)->get();
            if($user->isEmpty()){
                $user = CedulaVE::get($type_document,$document,false);
                $data=['status'=>'success','type'=>'not-user','user'=>$user];
            }else{
                $data=['status'=>'success','type'=>'user','user'=>$user[0]];
            }
        }else{
            $company=Company::where('RIF', $type_document.$document)->get();

            if($company->isEmpty()){
                $data=['status'=>'error','type'=>'not-company','company'=>null];
            }else{
                $data=['status'=>'success','type'=>'company','company'=>$company[0]];
                /*if($company->count()>1){
                    $data=['status'=>'error','message'=>'Este RIF, posse 2 licencia, por lo cual debe ingresar una licencia para indentificarla, selecione de tipo de documento la L e introduza el N de licencia..'];

                }else{
                }*/
            }
        }
        return response()->json($data);
    }

    public function registerCompanyUsers(Request $request){
//        dd($request->input('type')); die();
        $type=$request->input('type');
        $name=$request->input('name');
        $surname=$request->input('surname');
        $type_document=$request->input('type_document');
        $document=$request->input('document');
        $address=$request->input('address');
        $email=$request->input('email');

        if($type=='user'){

            $user=new User();
            $user->name=$name;
            $user->surname=$surname;
            $user->ci=$type_document.$document;
            $user->status_account='waiting';
            $user->address=$address;
            $user->email=$email;
            $user->role_id=3;
            $user->save();
            $id=$user->id;
        }else{
            $company=new Company();
            $company->name=$name;
            $company->RIF=$type_document.$document;
            $company->status='waiting';
            $company->address=$address;
            $company->save();
            $id=$company->id;

        }
        return response(['status'=>'success','id'=>$id,'type'=>$type]);
    }

    public function readCompanyProperties($company_id) {
        $propertiesArray = [];
        $userProperties = UserProperty::where('company_id', $company_id)->get();
        foreach($userProperties as $prop) {
            $propertiesArray[] = $prop->property_id;
        }
        $properties = Property::whereIn('id', $propertiesArray)->get();
//        dd($properties); die();
        $company = Company::find($company_id);
        session(['company' => $company]);

//        dd($company); die();
        return view('modules.properties.manage', ['properties' => $properties, 'company' => $company, 'userProperties' => $userProperties]);
    }


    public function homeTicketOffice(){
        return view('modules.ticket-office.property.home');
    }



}
