@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>カテゴリー追加</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'categories.store']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'カテゴリー名') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('追加', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}

        </div>
    </div>
@endsection