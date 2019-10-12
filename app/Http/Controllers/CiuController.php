<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ciu;

class CiuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $ciu= new ciu();
        $ciu->code= $request->input('code');
        $ciu->name= $request->input('name');
        $ciu->value= $request->input('value');
        $ciu->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {     
        $ciu= ciu::get();
        return view('dev.readCiu',array(
            'showCiu'=>$ciu
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


    public function filterCiu(Request $request){
        $ciuid=$request->input('id');
        foreach ($ciuid as $id){
            $ciu_find=Ciu::where('group_ciu_id',$id)->get();
            $ciu[]=$ciu_find;
        }


        return response()->json([['ciu'=>$ciu]]);
    }
}
