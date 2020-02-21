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
use App\Helpers\CedulaVE;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

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
        $catastralTerre = CatastralTerreno::orderBy('name','asc')->get();
        $catastralConst = CatastralConstruccion::orderBy('name','asc')->get();
        $parish = Parish::orderBy('name','asc')->get();
        $alicuota= Alicuota::orderBy('name','asc')->get();
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



        $property=Property::where('code_cadastral',$code_cadastral)->first();
        if(is_object($property)){
            return response()->json(['status'=>'error','message'=>'Ya existe un inmueble asociado a este código catastral, por favor ingrese un código valido']);
        }



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
        $owner_id = $request->input('id');
//        $type = $request->input('type');

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
        return view('modules.properties.ticket-office.home');
    }


    public function managerPropertyTicketOffice(){
        return view('modules.properties.module.manager');
    }


    public function createPropertyTicketOffice(){
        $catastralTerre = CatastralTerreno::all();
        $catastralConst = CatastralConstruccion::all();
        $parish = Parish::all();
        $alicuota= Alicuota::all();
        return view('modules.properties.module.register',[
            'parish' => $parish,
            'catasTerreno' => $catastralTerre,
            'catasConstruccion' => $catastralConst,
            'alicuota'=>$alicuota]);
    }


    public function detailsPropertyTicketOffice($id){
        $property=Property::find($id);
        $catastralTerre = CatastralTerreno::orderBy('name','asc')->get();
        $catastralConst = CatastralConstruccion::orderBy('name','asc')->get();
        $parish = Parish::orderBy('name','asc')->get();
        $alicuota= Alicuota::orderBy('name','asc')->get();

        $type='';

        $payments = $property->propertyTaxes()->orderBy('id', 'desc')->count();
//        dd($payments);

        if(!is_null($property->users[0]->pivot->person_id)){
            $type='users';
            $data=User::find($property->users[0]->pivot->person_id);

        }else{
            $type='company';
            $data=Company::find($property->users[0]->pivot->company_id);

        }


        return view('modules.properties.module.details',[
            'parish' => $parish,
            'catasTerreno' => $catastralTerre,
            'catasConstruccion' => $catastralConst,
            'alicuota'=>$alicuota,
            'property'=>$property,
            'type'=>$type,
            'data'=>$data,
            'payments' => $payments
        ]);
    }

    public function allTaxes($id) {
        $property = Property::findOrFail($id);
        $propertyTaxes = $property->propertyTaxes()->orderBy('id', 'desc')->get();
        session(['property' => $property]);
        return view('modules.properties.module.taxes', [
                'propertyTaxes' => $propertyTaxes,
                'property' => $property
            ]);
    }

    public function readPropertyTicketOffice(){
        $properties=Property::orderBy('id','desc')->get();
        return view('modules.properties.module.read',['properties'=>$properties]);
    }




    public function savePropertyTicketOffice(Request $request){


        $type=$request->input('type');

        $person_id=null;
        $company_id=null;


        $code_cadastral =
            $request->input('C1') .
            '-' . $request->input('C2') .
            '-' . $request->input('C3') .
            '-' . $request->input('C4') .
            '-' . $request->input('C5') .
            '-' . $request->input('C6') .
            '-' . $request->input('C7') .
            '-' . $request->input('C8');


        $property=Property::where('code_cadastral',$code_cadastral)->first();
        if(is_object($property)){
            return response()->json(['status'=>'error','message'=>'Ya existe un inmueble asociado a este código catastral, por favor ingrese un código valido']);
        }





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
        $person_id = $request->input('person_id');


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




            if($type == 'company'){
                $company=Company::find($owner_id);
                $user = $company->users()->get();


                $user_id = $user[0]->id;
                $company_id = $owner_id;
            } else {
                $user_id = $owner_id;
            }




//        $property->catastralConstruction()->attach(['value_catas_const_id' => $typeConst], ['property_id' => $id]); // Inserto en la tabla puente
        $property->users()->attach(['property_id' => $id], [
                                                            'user_id' => $user_id,
                                                            'status' => $status,
                                                            'person_id' => $person_id,
                                                            'company_id' => $company_id
            ]);

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










    public function findTaxPayers($type_document,$document,$band){
        if($type_document=='V'||$type_document=='E'){

            if($band==='true'){
                $user=User::where('ci', $type_document.$document)->get();
            }else{
                $user=User::where('ci', $type_document.$document)->where('status_account','!=','waiting')->get();
            }



            if($user->isEmpty()){
                if($band==='true'){
                    $user=CedulaVE::get($type_document,$document,false);
                    $data=['status'=>'success','type'=>'not-user','user'=>$user];
                }else{
                    $data=['status'=>'success','type'=>'not-user'];
                }
            }else{
                $data=['status'=>'success','type'=>'user','user'=>$user[0]];
            }

        }else{
            $company=Company::where('RIF', $type_document.$document)->orWhere('license',$type_document.$document)->get();

            if($company->isEmpty()){
                $data=['status'=>'error','type'=>'not-company','company'=>null];
            }else{

                if($company->count()>1){
                    $data=['status'=>'error','message'=>'Este RIF, posse 2 licencia, por lo cual debe ingresar una licencia para indentificarla, selecione de tipo de documento la L e introduza el N de licencia..'];

                }else{
                    $data=['status'=>'success','type'=>'company','company'=>$company[0]];
                }

            }

        }
        return response()->json($data);
    }


    public function updatePropertyTicketOffice(Request $request){


        $id = $request->input('id');
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

        $property =Property::find($id);
        $property->parish_id = $parish;
        $property->value_cadastral_ground_id = $location_cadastral;
       // $property->code_cadastral = $code_cadastral;
        $property->address = $address;
        $property->area_build = $area_build;
        $property->area_ground = $area_ground;
        $property->lat = $lat;
        $property->lng = $lng;
        $property->type_inmueble_id = $type_inmueble_id;
        $property->value_cadastral_build_id = $typeConst;
//        dd($owner_id); die();
        $property->update();

        response()->json(['status'=>'success','message'=>'Los datos del inmueble han sido actualizado con éxito']);

    }



    public function changeUserPropertyTicketOffice($property_id,$ci){

        $user=User::where('ci',$ci)->where('status_account','!=','waiting')->first();
        if(is_object($user)){
            $property=UserProperty::where('property_id',$property_id)->first();

            $property->user_id=$user->id;
            $property->update();
            $response=['status'=>'success','message'=>'Usuario de inmueble actualizado con éxito'];
        }else{
            $response=['status'=>'error','message'=>'Usuario no encontrado'];
        }
        return $response;

    }



    public function changePropietarioPropertyTicketOffice($type,$document,$property_id){

        if($type==='user'){
            $user=User::where('ci',$document)->where('status_account','!=','waiting')->first();

            if(is_object($user)){
                $property=UserProperty::where('property_id',$property_id)->first();
                $property->person_id=$user->id;
                $property->company_id=null;
                $property->update();
                $response=['status'=>'success','message'=>'Propietario de inmueble actualizado con éxito'];
            }else {
                $response = ['status' => 'error', 'message' => 'Usuario no encontrado'];
            }
        }else{
            $company=Company::where('RIF',$document)->first();

            if(is_object($company)){
                $property=UserProperty::where('property_id',$property_id)->first();
                $property->person_id=null;
                $property->user_id=$company->users[0]->id;
                $property->company_id=$company->id;


                $property->update();
                $response=['status'=>'success','message'=>'Propietario de inmueble y usuario web actualizado con éxito.'];
            }else {
                $response = ['status' => 'error', 'message' => 'Empresa no encontrada no encontrado'];
            }

        }


        return response()->json($response);
    }


    public function updatedMapPropertyTicketOffice(Request $request){
        $id=$request->input('id');
        $lat=$request->input('lat');
        $lng=$request->input('lng');

        $property=Property::find($id);
        $property->lat=$lat;
        $property->lng=$lng;
        $property->update();

        return response()->json(['status'=>'success']);
    }


    public function filterLocation($sector){
            $sector=CatastralTerreno::where('sector_catastral',$sector)->get();

            if($sector->isEmpty()){
                $sector=CatastralTerreno::where('sector_catastral',0)->get();
            }
            return response()->json(['status'=>'success','sector'=>$sector]);
    }



}
