<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{


    public function index(){
        $roles = Role::all();
        return view('dashboard.role.index')->with('roles', $roles);
    }

    public function create(){
        $permissions = Permission::all();
        return view('dashboard.role.create', ['permissions'=>$permissions]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'name'=>'required|unique:roles|max:10',
                'permissions' =>'required',
            ]
        );
//        $role->syncPermissions($request->input('permission'));
        $name = $request['name'];
        $role = Role::create(['guard_name' => 'admin','name' => $request->input('name')]);
//        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        return redirect(route('roles.index'));

    }
    public function show(){

    }

    public function edit($id){
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('dashboard.role.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id){

        $role = Role::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:10|unique:roles,name,'.$id,
            'permissions' =>'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();
        $p_all = Permission::all();

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p);
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form permission in db
            $role->givePermissionTo($p);
        }

        return redirect(route('roles.index'));


    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect(route('roles.index'));
    }

}
