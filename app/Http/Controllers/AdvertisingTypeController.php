<?php

namespace App\Http\Controllers;

use App\GroupPublicity;
use Illuminate\Http\Request;
use App\AdvertisingType;

class AdvertisingTypeController extends Controller
{
    public function manage() {
    	return view('modules.advertising.manage');
    }

    public function create() {
        $group=GroupPublicity::all();
    	return view('modules.advertising.register',['groups'=>$group]);
    }

    public function store(Request $request) {
    	$type = new AdvertisingType();
    	$type->name = $request->input('name');
    	$type->value = $request->input('value');
    	$type->group_publicity_id = $request->input('group_id');
    	$type->save();
    }

    public function show() {
    	$advertisingType = AdvertisingType::orderBy('id','desc')->get();
    	return view('modules.advertising.read', ['advertisingType' => $advertisingType]);
    }

    public function details($id) {
        $group=GroupPublicity::all();
    	$type = AdvertisingType::find($id);
    	return view('modules.advertising.details', ['type' => $type,'groups'=>$group]);
    }

    public function update(Request $request) {
    	$id = $request->input('id');
    	$type = AdvertisingType::find($id);
    	$type->name = $request->input('name');
    	$type->value = $request->input('value');
        $type->group_publicity_id = $request->input('group_id');
        $type->update();
    }
}
