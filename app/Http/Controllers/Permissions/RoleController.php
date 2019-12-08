<?php

namespace App\Http\Controllers\Permissions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    
    }

    public function index() {
    	return view('modules.security.roles.manage');
    }

    public function create () {
    	$role = new Role();
        $permissions = Permission::get();
    	return view('modules.security.roles.register', compact('permissions', 'role'));
    }

    public function store(Request $request) {
    	Validator::make($request->all(),[
            'name' => 'string|required'
        ])->validate();
        $role = Role::create($request->only('name'));
        $role->syncPermissions($request->get('permissions'));
        // var_dump($request->get()); die();
        return redirect()->route('roles.manage');
    }

    public function show(Role $role) {
    	$permissions = Permission::get();
    	$role = Role::get();
        return view('modules.security.roles.read', compact('role', 'permissions'));
    }

    public function details($id,Role $role) {
    	$role = Role::find($id);
    	$permissions = Permission::get();
        return view('modules.security.roles.details', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role) {
    	Validator::make($request->all(),[
            'name' => 'required|string'
        ])->validate();
        $id = $request->input('id');
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->update();
        $role->syncPermissions($request->get('permissions'));
    }

    public function destroy($id, Role $role) {
    	
    }
}
