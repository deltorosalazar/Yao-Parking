<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller {

    public function index() {
        $roles = Role::all();

        return view('roles.index', [
            'title' => 'Roles',
            'roles' => $roles
        ]);
    }

    public function store(Request $request) {
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        return response()->json($role);
    }

    public function update(Request $request) {
        $role = Role::findOrFail($request->id);
        $role->name = $request->name;
        $role->save();

        return response()->json($role);
    }

    public function changeState(Request $request) {
        $role = Role::findOrFail($request->id);
        $role->active = ($role->active == 1) ? 0 : 1;
        $role->save();

        return response()->json($role);
    }


}
