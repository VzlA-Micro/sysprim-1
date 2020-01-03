<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recharge;

class RechargeController extends Controller
{
    public function manage() {
    	return view('modules.recharges.manage');
    }

    public function create() {
    	return view('modules.recharges.register');
    }

    public function store(Request $request) {
    	$recharge = new Recharge();
    	$recharge->since = $request->input('since');
    	$recharge->to = $request->input('to');
    	$recharge->name = $request->input('name');
    	$recharge->value = $request->input('value');
    	$recharge->branch = $request->input('branch');
    	$recharge->save();
    }

    public function show() {
    	$recharges = Recharge::all();
    	return view('modules.recharges.read', ['recharges' => $recharges]);
    }

    public function details($id) {
    	$recharge = Recharge::find($id);
    	return view('modules.recharges.details', ['recharge' => $recharge]);
    }

    public function update(Request $request) {
    	$id = $request->input('id');
    	$recharge = Recharge::find($id);
    	$recharge->since = $request->input('since');
    	$recharge->to = $request->input('to');
    	$recharge->name = $request->input('name');
    	$recharge->value = $request->input('value');
    	$recharge->branch = $request->input('branch');
    	$recharge->update();
    }
}
