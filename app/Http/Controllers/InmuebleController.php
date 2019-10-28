<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parish;
use App\CatastralTerreno;
use App\Inmueble;
use App\UserInmueble;
use App\Val_cat_const_inmu;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder\Property;
use App\CatastralConstruccion;

class InmuebleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inmuebles=UserInmueble::where('user_id',\Auth::user()->id)->select('inmueble_id')->get();
        $inmueble_find=Inmueble::whereIn('id',$inmuebles)->get();
        return view('dev.inmueble.menu',['inmuebles'=>$inmueble_find]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $catastralTerre=CatastralTerreno::all();
        $catastralConst=CatastralConstruccion::all();
        $parish=Parish::all();
        return view('dev.inmueble.register',['parish'=>$parish,'catasTerreno'=>$catastralTerre,'catasConstruccion'=>$catastralConst]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code_cadastral = $request->input('codigo_cadastral');
        $location_cadastral = $request->input('location_cadastral');
        $area = $request->input('area');
        $parish = $request->input('parish');
        $address = $request->input('address');
        $lat=$request->input('lat');
        $lng=$request->input('lng');
        $typeConst=$request->input('type_const');

        $property=new Inmueble();

        $property->parish_id=$parish;
        $property->value_catastral_terreno_id=$location_cadastral;
        $property->codigo_catastral=$code_cadastral;
        $property->direccion=$address;
        $property->area=$area;
        $property->lat=$lat;
        $property->lng=$lng;

        $property->save();

        $id = DB::getPdo()->lastInsertId();
        $property->user()->attach(['inmueble_id' => $id], ['user_id' => \Auth::user()->id]);
        $property->catasConstruct()->attach(['' => $typeConst],['inmueble_id' => $id]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property=Inmueble::where('id',$id)->get();
        $pCatasConstruct=Val_cat_const_inmu::where('inmueble_id',$id)->select('value_catas_const_id')->get();
        //$catasConstruct=CatastralConstruccion::find($pCatasConstruct->value_catas_const_id);
        //$catasTerreno=CatastralTerreno::find($property->value_catastral_terreno_id);
        //$parish=Parish::find($property->parish_id);
        var_dump($pCatasConstruct);
        die();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property=Inmueble::where('id',$id)->get();

        var_dump($property);
        die();

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
        //$id=$request->input('id');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
