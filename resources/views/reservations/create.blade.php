@extends('layouts.app')

@section('content')

    <h1>貸出予約</h1>
    
    <div class="row">
        {!! Form::model($reservation,['route' => 'reservations.reserve_check']) !!}
        
        <div class="form-group d-flex">
            <div class="col-sm-3">{!! Form::label('reserve_date', '貸出期間：') !!}</div>
            <div class="col-sm-6">{!! Form::date('reserve_date', null, ['class' => 'form-control']) !!}</div>
            <div class="col-sm-3">{!! Form::time('reserve_time_start', null, ['class' => 'form-control']) !!}</div>～
            <div class="col-sm-3">{!! Form::time('reserve_time_end', null, ['class' => 'form-control']) !!}</div>
        </div>
        
        <div class="form-group d-flex">
            <div class="col-sm-3">{!! Form::label('category_id', 'カテゴリー：') !!}</div>
            <div class="col-sm-6">{!! Form::select('category_id', $category, null, ['class' => 'form-control']) !!}</div>
        </div>
            
        <div class="form-group d-flex">
            <div class="col-sm-3">{!! Form::label('number', '必要台数：') !!}</div>
            <div class="col-sm-6">{!! Form::text('number', null, ['class' => 'form-control']) !!}</div>台
        </div>
        
        <div class="form-group d-flex">
            <div class="form-group col-sm-4">
                {!! Form::label('reserve_check', '空き状況：') !!}
            </div>
            <div>
                @if( $empty_check == 1 )
                    {!! Form::label('reserve_check', 'OK（予約リストに追加できます）', ['style' => 'color:lightgreen']) !!}
                @elseif( $empty_check == 2 )
                    {!! Form::label('reserve_check', 'NG（'. count($equipments). '台まで貸出可能です）', ['style' => 'color:red']) !!}
                @else
                @endif
            </div>
        </div>
        <div class="form-group d-flex">
            <div class="col-sm-4">
                {!! Form::submit('空き状況確認', ['class' => 'btn btn-primary btn-block']) !!}
            </div>
            {!! Form::close() !!}
            
            <div class="col-sm-4">
            {!! Form::open(['route' => 'reservations.reserve']) !!}
                @if( $empty_check == 1 )
                    {!! Form::submit('予約リスト追加', ['class' => 'btn btn-primary btn-block']) !!}
                    {!! Form::hidden('reserve_date',$reservation->reserve_date) !!}
                    {!! Form::hidden('reserve_time_start',$reservation->reserve_time_start) !!}
                    {!! Form::hidden('reserve_time_end',$reservation->reserve_time_end) !!}
                    {!! Form::hidden('category_id',$reservation->category_id) !!}
                    {!! Form::hidden('number',$reservation->number) !!}
                @else
                    {!! Form::submit('予約リスト追加', ['class' => 'btn btn-secondary btn-block', 'disabled']) !!}
                @endif
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    
    <hr>
    
    <h1>予約リスト</h1>
    
    @if (count($reservations_confirm) > 0)
    
    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>カテゴリー名</th>
                <th>製品名</th>
                <th>貸出開始</th>
                <th>貸出終了</th>
                <th>取消</th>
            </tr>
        </thead>
        <tbody>
            {{ '', $count = 0 }}
            @foreach ($reservations_confirm as $reservation_confirm)
                <tr>
                    <td>{{ $reservation_confirm->equipment->name }}</td>
                    <td>{{ $reservation_confirm->equipment->category->name }}</td>
                    <td>{{ $reservation_confirm->lending_start }}</td>
                    <td>{{ $reservation_confirm->lending_end }}</td>
                    <td>
                        {{-- カテゴリー削除ボタンのフォーム --}}
                        {!! Form::open(['route' => ['reservations.destroy', $reservation_confirm->id], 'method' => 'delete', ]) !!}
                            {!! Form::hidden('page',1) !!}
                            <input type="image" src="{{asset('image/batsu.png')}}" width="20" height="20">
                        {!! Form::close() !!}
                    </td>
                    {!! Form::hidden('reservation_id['. $count++. ']', $reservation_confirm->id, ['form' => "destroyForm"]) !!}
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {!! Form::open(['route' => 'reservations.store']) !!}
        <div class="form-group col-sm-4">
            {!! Form::submit('予約', ['class' => 'btn btn-primary btn-block']) !!}
        </div>
    {!! Form::close() !!}
    
    {{-- 全取消ボタンのフォーム --}}
    {!! Form::open(['route' => ['reservations.destroy_all'], 'method' => 'delete', 'id' => 'destroyForm']) !!}
        <div class="form-group col-sm-4">
            {!! Form::submit('全取消', ['class' => "btn btn-danger btn-block btn-sm"]) !!}
        </div>
    {!! Form::close() !!}
    
    @endif

@endsection