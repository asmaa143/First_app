<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return view('dashboard.permission.index')->with('permissions', $permissions);
    }


    public function create()
    {
        $roles = Role::get();

        return view('dashboard.permission.create')->with('roles', $roles);
    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $name = $request['name'];
        $permission = Permission::create(['guard_name' => 'admin','name' => $request->input('name')]);
//        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) {
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first();
                $r->givePermissionTo($permission);
            }
        }

        return redirect(route('permissions.index'));
    }


    public function show()
    {

    }


    public function edit($id)
    {
        $permission = Permission::find($id);

        return view('dashboard.permission.edit', compact('permission'));
    }


    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $input = $request->all();
        $permission->fill($input)->save();
        return redirect(route('permissions.index'));

    }


    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

//        if ($permission->name == "Administer roles & permissions") {
//            return redirect(route('permissions.index'));
//        }

        $permission->delete();
        return redirect(route('permissions.index'));

    }
}
