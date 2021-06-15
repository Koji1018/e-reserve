@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>備品編集</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3 mt-3">
            {!! Form::model($equipment, ['route' => ['equipments.update', $equipment->id], 'method' => 'put']) !!}
            
                <div class="form-group d-flex">
                    <div>
                        {!! Form::label('category', 'カテゴリー：') !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select('category', $category, $equipment->category_id, ['class' => 'form-control']) !!}
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
                
                <div class="form-group d-flex">
                    <div>
                        {!! Form::label('status', 'ステータス：') !!}
                    </div>
                    <div class="col-sm-9">
                        {!! Form::select('status', ["貸出可能","貸出不可"], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-sm-6 offset-sm-3">
                    {!! Form::submit('更新', ['class' => 'btn btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection