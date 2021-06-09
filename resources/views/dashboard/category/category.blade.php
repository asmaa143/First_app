@extends('dashboard.common.app')
@section('title','dashboard')
@section('content')
    <div class="container" style="margin-top: 100px">
        <a href="{{route('category.create')}}">Add Category</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Photo</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cat as $cat)
                <tr>
                    <th scope="row">{{$cat->id}}</th>
                    <td>{{$cat->name}}</td>
                    <td><img width="100px" src="{{asset('Upload/cat/'.$cat->img)}}" alt=""></td>
                    <td>

                        <a href="{{route('category.edit',$cat->id)}}" class="btn btn-sm btn-info">edit</a>
                        {!! Form::open(['route' => ['category.destroy',$cat->id],'method'=>'DELETE']) !!}
                        @csrf
                        {!! Form::submit('delete Category!',['class'=>'btn btn-danger']) !!}
                        {!! Form::close() !!}
{{--                        <a href="{{route('category.destroy',$cat->id)}}" class="btn btn-sm btn-danger">delete</a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


@endsection
