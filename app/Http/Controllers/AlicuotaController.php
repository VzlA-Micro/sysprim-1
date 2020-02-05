<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alicuota;
class AlicuotaController extends Controller
{
    public function manage() {
        return view('modules.alicuota.manage');
    }

    public function show() {
        $alicuotas = Alicuota::all();
        return view('modules.alicuota.read', ['alicuotas' => $alicuotas]);

    }

    public function details($id) {
        $alicuota =Alicuota::find($id);
        return view('modules.alicuota.details', ['alicuota' => $alicuota]);

    }

    public function update(Request $request) {
        $id = $request->input('id');
        $alicuota = Alicuota::find($id);
        $alicuota->name = $request->input('name');
        $alicuota->value = $request->input('value')/100;
        $alicuota->update();
    }
}
