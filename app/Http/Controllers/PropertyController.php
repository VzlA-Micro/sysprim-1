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

class PropertyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inmuebles = UserProperty::where('user_id', \Auth::user()->id)->select('property_id')->get();
        $inmueble_find =Inmueble::whereIn('id', $inmuebles)->get();
        return view('dev.inmueble.menu', ['inmuebles' => $inmueble_find]);
    }

    public function myProperty()
    {
        $inmuebles = UserProperty::where('user_id', \Auth::user()->id)->select('property_id')->get();
        $inmueble_find =Inmueble::whereIn('id', $inmuebles)->get();
        return view('dev.inmueble.menuPayments', ['inmuebles' => $inmueble_find]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $catastralTerre = CatastralTerreno::all();
        $catastralConst = CatastralConstruccion::all();
        $parish = Parish::all();
        return view('dev.inmueble.register', ['parish' => $parish, 'catasTerreno' => $catastralTerre, 'catasConstruccion' => $catastralConst]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        $property = new Inmueble();

        $property->parish_id = $parish;
        $property->value_cadastral_ground_id = $location_cadastral;
        $property->code_cadastral = $code_cadastral;
        $property->address = $address;
        $property->area_build = $area_build;
        $property->area_ground = $area_ground;
        $property->lat = $lat;
        $property->lng = $lng;

        $property->save();

        $id = DB::getPdo()->lastInsertId();

        $valCat = new Val_cat_const_inmu();
        $valCat->value_catas_const_id = $typeConst;
        $valCat->property_id = $id;
        $valCat->save();

        $useProperty= new UserProperty();
        $useProperty->user_id=\Auth::user()->id;
        $useProperty->property_id=$id;
        $useProperty->save();


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
        return view('dev.inmueble.details', array(
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
}
