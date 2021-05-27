@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>カテゴリー編集</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'put']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'カテゴリー名') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('更新', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}

        </div>
    </div>
@endsection