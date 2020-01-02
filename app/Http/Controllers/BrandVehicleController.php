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

class BrandVehicleController extends Controller
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

        return view('modules.vehicles_brand.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brand= new Brand();
        $brand->name= $request->input('name');
        $brand->save();

        return redirect()->route('vehicles.brand.read');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $brand = Brand::get();
        return view('modules.vehicles_brand.read',array(
            'showBrand'=>$brand
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
        $brand = Brand::findOrFail($id);
        return view('modules.vehicles_brand.details',array(
            'brand'=>$brand
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
        $brand=Brand::findOrFail($request->input('id'));
        $brand->name= $request->input('name');
        $brand->update();
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
        $brand=Brand::destroy($id);
        return redirect()->route('.read');
    }

    public function verifyBrand(Request $request){
        $brand = Brand::where('name', $request->input('brand'))->exists();
        return response()->json($brand);
    }
}
