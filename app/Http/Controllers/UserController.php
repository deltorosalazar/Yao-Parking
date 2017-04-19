<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UserController extends Controller {

    public function index() {
        $users = User::all();
        $roles = Role::where('active', '1')->orderBy('name', 'asc')->get();

        return view('users.index', [
            'title' => 'Usuarios',
            'users' => $users,
            'roles' => $roles
        ]);
    }

    public function store(Request $request) {
        $user = new User();
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return response()->json([
            'name' => $user->name,
            'role_id' => $user->role_id,
            'role_name' => $user->role->name,
            'phone' => $user->phone,
            'email' => $user->email
        ]);

        // return response()->json($user);
    }

    public function update(Request $request) {
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'role_id' => $user->role_id,
            'role_name' => $user->role->name,
            'phone' => $user->phone,
            'email' => $user->email
        ]);
    }

    public function changeState(Request $request) {
        $user = User::findOrFail($request->id);
        $user->active = ($user->active == 1) ? 0 : 1;

        $user->save();

        return response()->json($user);
    }


}
