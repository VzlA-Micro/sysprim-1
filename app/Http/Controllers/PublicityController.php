<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publicity;
use App\AdvertisingType;

class PublicityController extends Controller
{
    public function index() {

    }

    public function create() {
    	$advertisingTypes = AdvertisingType::all();
    	return view('modules.publicity.register',['advertisingTypes' => $advertisingTypes]);
    }

    public function show() {
    	return view('modules.publicity.read');
    }

}
