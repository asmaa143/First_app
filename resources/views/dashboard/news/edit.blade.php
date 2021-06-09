@extends('dashboard.common.app')
@section('title','dashboard')
@section('content')
    <div class="container" style="margin-top: 100px">
        {{Form::model($cat, ['route' => ['news.update', $cat->id],'enctype'=>'multipart/form-data','method'=>'PUT'])}}
         {{ Form::hidden('id',$cat->id)}}
            <div class="form-group">
                {!! Form::label('name','Name')  !!}
                {{ Form::text('name',$cat->name,['class'=>'form-control'])}}
            </div>
            <img src="{{asset('Upload/cat/'.$cat->img)}}"width="50px" alt="">
            <div class="form-group">
                {{ Form::file('img',['class'=>'form-control-file'])}}
            </div>
            {!! Form::submit('edit Category!',['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>

@endsection
