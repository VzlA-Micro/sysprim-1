<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdvertisingType;

class AdvertisingTypeController extends Controller
{
    public function manage() {
    	return view('modules.advertising.manage');
    }

    public function create() {
    	return view('modules.advertising.register');
    }

    public function store(Request $request) {
    	$type = new AdvertisingType();
    	$type->name = $request->input('name');
    	$type->value = $request->input('value');
    	$type->save();
    }

    public function show() {
    	$advertisingType = AdvertisingType::all();
    	return view('modules.advertising.read', ['advertisingType' => $advertisingType]);
    }

    public function details($id) {
    	$type = AdvertisingType::find($id);
    	return view('modules.advertising.details', ['type' => $type]);
    }

    public function update(Request $request) {
    	$id = $request->input('id');
    	$type = AdvertisingType::find($id);
    	$type->name = $request->input('name');
    	$type->value = $request->input('value');
    	$type->update();
    }
}
