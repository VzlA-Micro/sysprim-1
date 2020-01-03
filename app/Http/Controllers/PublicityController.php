<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publicity;
use App\AdvertisingType;
use App\AdvertisingTypePublicity;


class PublicityController extends Controller
{
    public function index() {

    }

    public function create() {
    	$advertisingTypes = AdvertisingType::all();
    	return view('modules.publicity.register',['advertisingTypes' => $advertisingTypes]);
    }

    public function store(Request $request) {
    	$publicity = new Publicity();
    	$publicity->name = $request->input('name');
    	$publicity->date_start = $request->input('date_start');
    	$publicity->date_end = $request->input('date_end');
    	$publicity->unit = $request->input('unit');
    	
    }

    public function show() {
    	return view('modules.publicity.read');
    }

}
