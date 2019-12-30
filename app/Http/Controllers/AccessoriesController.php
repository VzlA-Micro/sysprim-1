<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accessory;

class AccessoriesController extends Controller
{
    public function manage() {
    	return view('modules.accessories.manage');
    }

    public function create() {
    	return view('modules.accessories.register');
    }

    public function store(Request $request) {
    	$accessory = new Accessory();
    	$accessory->name = $request->input('name');
    	$accessory->value = $request->input('value');
    	$accessory->save();
    }

    public function show() {
    	$accessories = Accessory::all();
    	return view('modules.accessories.read', ['accessories' => $accessories]);

    }

    public function details($id) {
    	$accessory = Accessory::find($id);
    	return view('modules.accessories.details', ['accessory' => $accessory]);

    }

    public function update(Request $request) {
    	$id = $request->input('id');
    	$accessory = Accessory::find($id);
    	$accessory->name = $request->input('name');
    	$accessory->value = $request->input('value');
    	$accessory->update();
    }

    public function destroy() {
    	
    }
}
