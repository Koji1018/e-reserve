@extends('layouts.app')

@section('content')

    <h1>全体貸出状況</h1>
    
    {{-- フィルタ用のフォーム --}}
    {!! Form::model($datetime,['route' => ['reservations.filter_index_all'], 'method' => 'get']) !!}
    <div class="row form-group d-flex mt-3">
        <div class="col-12 col-md-2">{!! Form::date('filter_date', $datetime->format('Y-m-d'),[]) !!}</div>
        <div class="col-3 col-md-1">{!! Form::time('filter_time_start', $datetime->format('H:i'),[]) !!}</div>
        <div class="pl-2">～</div>
        <div class="col-3 col-md-1">{!! Form::time('filter_time_end', $aftertime,[]) !!}</div>
        <div class="pl-2">{!! Form::label('の貸出状況') !!}</div>
        <div class="col-3 px-3">
            {!! Form::submit('更新', null) !!}
        </div>
    </div>
    {!! Form::close() !!}
    
    <hr>
    
    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>カテゴリー名</th>
                <th>貸出可能</th>
                <th>貸出予約済</th>
                <th>合計</th>
            </tr>
        </thead>
        <tbody>
            {{ '', $count = 0 }}
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $reserve_oks[$count] }}</td>
                <td>{{ $reserve_ngs[$count] }}</td>
                <td>{{ $totals[$count] }}</td>
            </tr>
            {{ '', $count++ }}
            @endforeach
        </tbody>
    </table>

@endsection