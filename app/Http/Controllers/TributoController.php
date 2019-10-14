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

        return redirect()->route('readTributo');
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
        return view('dev.tributo.read',array(
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
        $ciu= ciu::findOrFail($id);
        return view('dev.detailsCiu',array(
            'ciu'=>$ciu
        ));
        
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
        $ciu=ciu::findOrFail($id);
        
        $ciu->code= $request->input('code');
        $ciu->name= $request->input('name');
        $ciu->value= $request->input('value');
        
        $ciu->update(); 
        return redirect()->route('readCiu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ciu=ciu::destroy($id);
        return redirect()->route('readCiu');
    }
}
