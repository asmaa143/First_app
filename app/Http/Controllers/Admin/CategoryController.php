<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Image;


use Illuminate\Http\Request;

class CategoryController extends Controller
{


   public function index(){
       $data['cat']=Category::select('id','name','img')->get();

       return view('dashboard.category.category')->with($data);


   }


   public function create(){

       return view('dashboard.category.create');
   }



        public function store(Request $request)
        {

            $data = $request->validate([
                'name' => 'required|string',
                'img' => 'required|image|mimes:jpg,png',
            ]);


            $new_name = $data['img']->hashName();
            Image::make($data['img'])->resize(50, 50)->save(public_path('Upload/cat/' . $new_name));
            $data['img'] = $new_name;
            Category::create($data);
            return back();
        }
        public function show(){

        }

    public function edit($id){
       $data['cat']=Category::findOrFail($id);

       return view('dashboard.category.edit')->with($data);
    }

    public function update(Request $request){

        $data=$request->validate([
            'name'=>'required|string',
            'img'=>'nullable|image|mimes:jpg,png',
        ]);
        $old_name=Category::findOrFail($request->id)->img;
        if($request->hasFile('img'))
        {
            Storage::disk('uploads')->delete('cat/'.$old_name);
            $new_name=$data['img']->hashName();
            Image::make($data['img'])->resize(50,50)->save(public_path('Upload/cat/'.$new_name));
            $data['img']=$new_name;
        }
        else{
             $data['img']=$old_name;
        }

        Category::findOrFail($request->id)->update($data);

       return back();

    }

    public function destroy($id){
        $old_name=Category::findOrFail($id)->img;
        Storage::disk('uploads')->delete('cat/'.$old_name);
        Category::findOrFail($id)->delete();

    }

}
