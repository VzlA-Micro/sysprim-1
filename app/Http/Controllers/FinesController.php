<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\fine;

class FinesController extends Controller
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
        $fine= new Fine();
        $fine->name= $request->input('name');
        $fine->cant_unid_tribu= $request->input('undTributo');
        $fine->save();

        return redirect()->route('readFines');
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
        $fines= Fine::get();
        return view('dev.fines.read',array(
            'showFines'=>$fines
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
        $fines = Fine::findOrFail($id);
        return view('dev.fines.details',array(
            'fines'=>$fines
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
        $fines=Fine::findOrFail($id);
        
        $fines->name= $request->input('name');
        $fines->cant_unid_tribu= $request->input('undTributo');
       
        $fines->update(); 
        return redirect()->route('readFines');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fines=Fine::destroy($id);
        return redirect()->route('readFines');
    }
}
