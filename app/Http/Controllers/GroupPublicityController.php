<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupPublicity;

class GroupPublicityController extends Controller
{
    public function index()
    {
        return view('modules.publicity.group.manage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('modules.publicity.group.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group= new GroupPublicity();
        $group->name= ucwords($request->input('name'));
        $group->save();

        return response()->json(['group'=>$group]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $groupPublicity = GroupPublicity::get();
        return view('modules.publicity.group.read',array(
            'showGroups'=>$groupPublicity
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
        $groupPublicity = GroupPublicity::findOrFail($id);
        return view('modules.publicity.group.details',array(
            'GroupPublicity'=>$groupPublicity
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

        $group=GroupPublicity::findOrFail($request->input('id'));
        $group->name= $request->input('name');
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
