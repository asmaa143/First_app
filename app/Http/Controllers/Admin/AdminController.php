<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $data['admin']=Admin::select('id','name','email')->get();
        return view('dashboard.Admin.index')->with($data);

    }

    public function create(){
        $roles = Role::get();
        return view('dashboard.Admin.create', ['roles'=>$roles]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:admins',
            'password'=>'required|min:6|confirmed',
        ]);

        $admin = Admin::create($request->only('email', 'name','password'));

        $roles = $request['roles'];

        if (isset($roles)) {

            foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $admin->assignRole($role_r);
            }
        }

        return back();
    }
    public function show(){

    }
    public function edit($id){
        $admin = Admin::findOrFail($id);
        $roles = Role::get();
        return view('dashboard.Admin.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, $id){
        $admin = Admin::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:admins,email,'.$id,
            'password'=>'required|min:6|confirmed'
        ]);

        $input = $request->only(['name', 'email', 'password']);
        $roles = $request['roles'];
        $admin->fill($input)->save();

        if (isset($roles)) {
            $admin->roles()->sync($roles);
        }
        else {
            $admin->roles()->detach();
        }
        return redirect(route('admins.index'));

    }

    public function destroy($id){
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect(route('admins.index'));

    }

}
