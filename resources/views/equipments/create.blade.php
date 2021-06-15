@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>備品追加</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3 mt-3">

            {!! Form::open(['route' => 'equipments.store']) !!}
            
                <div class="form-group d-flex">
                    <div>
                        {!! Form::label('category_id', 'カテゴリー：') !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select('category_id', $category, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                
                <div class="form-group d-flex">
                    <div>
                        {!! Form::label('name', '製品名：　　') !!}
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