@extends('dashboard.common.app')
@section('title','dashboard')
@section('content')

    <div class="container" style="margin-top: 100px">

        {!! Form::open(['route' => 'category.store','method'=>'post','files' => true]) !!}
        {{Form::token()}}
        <div class="form-group">
            {!! Form::label('name','Name')  !!}
            {{ Form::text('name',null,['class'=>'form-control'])}}
        </div>
        <div class="form-group">
            {{ Form::file('img',['class'=>'form-control-file'])}}

        </div>
        {!! Form::submit('Add Category!',['class'=>'btn btn-primary']) !!}

        {!! Form::close() !!}
    </div>
{{--    @dump($errors)--}}
@endsection
