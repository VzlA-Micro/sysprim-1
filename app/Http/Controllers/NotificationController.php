<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index() {
    	return view('modules.notifications.manage');
    }

    public function create() {
    	return view('modules.notifications.register');

    }

    public function store() {

    }

    public function show() {
    	return view('modules.notifications.show');
    }
}
