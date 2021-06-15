@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>管理者追加</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3 mt-3">

            {!! Form::open(['route' => 'admin.update']) !!}
                <div class="form-group d-flex">
                    <div>
                        {!! Form::label('name', 'ユーザ名：') !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-sm-6 offset-sm-3">
                    {!! Form::submit('追加', ['class' => 'btn btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection