@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>備品編集</h1>
    </div>

    {!! Form::model($equipment, ['route' => ['equipments.update', $equipment->id], 'method' => 'put']) !!}
    <div class="form-group d-flex row mt-3">
        <div class="offset-md-3 col-md-2">
            {!! Form::label('category', 'カテゴリー：') !!}
        </div>
        <div class="col-8 col-md-4">
            {!! Form::select('category', $category, $equipment->category_id, ['class' => 'form-control']) !!}
        </div>
    </div>
    
    <div class="form-group d-flex row">
        <div class="offset-md-3 col-md-2">
            {!! Form::label('name', '製品名：　　') !!}
        </div>
        <div class="col-8 col-md-4">
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
    </div>
            
    <div class="form-group d-flex row">
        <div class="offset-md-3 col-md-2">
            {!! Form::label('status', 'ステータス：') !!}
        </div>
        <div class="col-8 col-md-4">
            {!! Form::select('status', ["貸出可能","貸出不可"], null, ['class' => 'form-control']) !!}
        </div>
    </div>
    
    <div class="col-4 offset-4 offset-md-5 col-md-2">
        {!! Form::submit('更新', ['class' => 'btn btn-primary btn-block']) !!}
    </div>
    {!! Form::close() !!}

@endsection