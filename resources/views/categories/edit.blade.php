@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>カテゴリー編集</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3 mt-3">
            {!! Form::model($category, ['route' => ['categories.update', $category->id], 'method' => 'put']) !!}

                <div class="form-group d-flex">
                    <div>
                        {!! Form::label('name', 'カテゴリー名：') !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-sm-6 offset-sm-3">
                    {!! Form::submit('更新', ['class' => 'btn btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection