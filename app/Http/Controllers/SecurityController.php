<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;


class SecurityController extends Controller
{
    public function index() {
    	return view('modules.security.manage');
    }

    public function audits() {
    	$audits = Audit::get();
    	return view('modules.security.audits', ['audits' => $audits]);
    }
}
