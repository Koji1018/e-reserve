@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>管理者追加</h1>
    </div>

    {!! Form::open(['route' => 'admin.update']) !!}
    <div class="form-group d-flex row mt-3">
        <div class="col-4 offset-md-3 col-md-2">
            {!! Form::label('name', 'ユーザ名：') !!}
        </div>
        <div class="col-8 col-md-4">
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-4 offset-4 offset-md-5 col-md-2">
        {!! Form::submit('追加', ['class' => 'btn btn-primary btn-block']) !!}
    </div>
    {!! Form::close() !!}
    
@endsection