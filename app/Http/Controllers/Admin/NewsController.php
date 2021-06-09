<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
//use App\Repositories\Repository;
use Illuminate\Http\Request;

class NewsController extends Controller
{


public function index(){

  $data['news']=News::with('admin')->get();
    return view('dashboard.news.index')->with($data);

}
}
