<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prologue;
class PrologueController extends Controller
{
    //
    public function manage() {
        return view('modules.prologue.manage');
    }

    public function index() {
        $prologue = Prologue::all();
        return view('modules.prologue.read', ['prologues' => $prologue]);

    }
    public function details($id) {
        $prologue = Prologue::find($id);
        return view('modules.prologue.details', ['prologue' => $prologue]);
    }



    public function update(Request $request) {
        $id = $request->input('id');
        $prologue = Prologue::find($id);
        $prologue->date_limit = $request->input('date_limit');
        $prologue->update();
        return response()->json(['message'=>'El dia de cobro ha sido cambiado con éxito.']);
    }

}
