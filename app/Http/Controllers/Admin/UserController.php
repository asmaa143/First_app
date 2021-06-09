<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::all();
        return view('dashboard.users.index')->with($data);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'img' => 'required|image|mimes:jpg,png',
            'email' => 'required|email|unique:users',
            'phone' => 'required|array|min:1',
            'password' => 'required|min:5',
        ]);

        $data = $request->except('phone');
        $new_name = $data['img']->hashName();
        Image::make($data['img'])->resize(50, 50)->save(public_path('Upload/users/' . $new_name));
        $data['img'] = $new_name;
        $user = User::create($data);
        foreach ($request->input('phone') as $phone) {
            $user->phone()->create(['phone' => $phone]);

        }

        return view('dashboard.users.row', compact('user'));

    }

    public function edit($id)
    {
        $data = User::findOrfail($id);
        return view('dashboard.users.edit', compact('data'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,png',
            'email' => 'required|email',
            'phone' => 'required|array|min:1',
            'password' => 'nullable|min:5',
        ]);
        $data=User::findOrFail($request->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->save();

        $respond['user'] = $data;
        return view('dashboard.users.rowedit')->with($respond);

    }

    public function show()
    {

    }

    public function destroy($id)
    {
        $old_name = User::findOrFail($id)->img;
        Storage::disk('uploads')->delete('users/' . $old_name);
        User::findOrFail($id)->delete();
        return response()->json(['message' => "deleted success", 'id' => $id]);
    }


}
