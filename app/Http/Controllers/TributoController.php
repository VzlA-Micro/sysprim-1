<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tributo;

class TributoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    
    public function store(Request $request)
    {
        $tributo= new Tributo();
        $tributo->since= $request->input('since_date');
        $tributo->to= $request->input('to_date');
        $tributo->value= $request->input('valueUndTributo');
        $tributo->save();
        $response = [
            'status' => 'success',
            'message' => 'Se ha registrado la nueva unidad tributaria.'
        ];
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {     
        $tributo= Tributo::get();
        return view('modules.tax-unit.read',array(
            'showTributo'=>$tributo
        ));
        //return $ciu;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
