<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupCiiu;

class GroupCiiuController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $groupCiiu= new GroupCiiu();
        $groupCiiu->code= $request->input('code');
        $groupCiiu->name= $request->input('name');
        $groupCiiu->save();

        return redirect()->route('ciu-group.read');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {     
        $groupCiiu = GroupCiiu::get();
        return view('modules.ciiu-group.read',array(
            'showGroupCiiu'=>$groupCiiu
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
        $ciu=ciu::destroy($id);
        return redirect()->route('readCiu');
    }
}