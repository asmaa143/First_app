@extends('dashboard.common.app')
@section('title','dashboard')
@section('content')
    <div class="container" style="margin-top: 100px">
        <a href="{{route('news.create')}}">Add News</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">photo</th>
                <th scope="col">Title_en</th>
                <th scope="col">Title_ar</th>
                <th scope="col">Description</th>
                <th scope="col">Admin</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($news as $new)
                <tr>
                    <th scope="row">{{$new->id}}</th>
                    <td><img width="100px" src="{{asset('Upload/news/'.$new->img)}}" alt=""></td>
                    <td>{{$new->title_en}}</td>
                    <td>{{$new->title_ar}}</td>
                    <td>{{$new->description}}</td>
                    <td>{{$new->admin->name}}</td>
                    <td>

                        <a href="" class="btn btn-sm btn-info">edit</a>
{{--                        {!! Form::open(['route' => ['news.destroy',$cat->id],'method'=>'DELETE']) !!}--}}
                        @csrf
                        {!! Form::submit('delete News!',['class'=>'btn btn-danger']) !!}
                        {!! Form::close() !!}
{{--                        <a href="{{route('category.destroy',$cat->id)}}" class="btn btn-sm btn-danger">delete</a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


@endsection
