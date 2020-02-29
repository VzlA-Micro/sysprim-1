<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ForeignExchange;

class ForeignExchangeController extends Controller
{
    public function index(){
        $foreignExchange = ForeignExchange::orderBy('id','desc')->get();
        return view('modules.foreign-exchange.read',array(
            'foreignExchanges'=>$foreignExchange
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('modules.foreign-exchange.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $foreignExchange= new ForeignExchange();
        $foreignExchange->name= ucwords($request->input('name'));
        $foreignExchange->value= $request->input('value');
        $foreignExchange->save();
        $response = [
            'status' => 'success',
            'message' => 'El valor de la moneda se ha registrado con éxito.',
            'foreignExchange' => $foreignExchange];
        return response()->json($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $foreignExchange = ForeignExchange::findOrFail($id);
        return view('modules.foreign-exchange.details',array(
            'foreignExchange'=>$foreignExchange
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request)
    {

        $group=ForeignExchange::findOrFail($request->input('id'));
        $group->name= $request->input('name');
        $group->value= $request->input('value');
        $group->update();
        $update=true;
        return response()->json(['update'=>$update]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function verifyName(Request $request){
        $group = GroupPublicity::where('name', $request->input('group'))->exists();
        return response()->json($group);
    }
}

