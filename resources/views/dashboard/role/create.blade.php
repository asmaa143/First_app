@extends('dashboard.common.app')
@section('title','dashboard')
@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h1><i class='fa fa-key'></i> Add Role</h1>
        <hr>
        {{-- @include ('errors.list') --}}
{{--        @dump($errors)--}}
        {{ Form::open(['route' => 'roles.store','method'=>'post']) }}

        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <h5><b>Assign Permissions</b></h5>

        <div class='form-group'>
            @foreach ($permissions as $permission)
                {{ Form::checkbox('permissions[]',  $permission->id ) }}
                {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>

            @endforeach
        </div>

        {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>
{{--    @dump($errors)--}}
@endsection
