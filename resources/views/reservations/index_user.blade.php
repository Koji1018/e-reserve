@extends('layouts.app')

@section('content')

    <h1>{{ Auth::user()->name }}さんの予約状況</h1>
    
    
    {{-- フィルタ用のフォーム --}}
    {!! Form::model($datetime,['route' => ['reservations.filter_index_user'], 'method' => 'get']) !!}
    <div class="form-group d-flex flex-row mt-3">
        <div>
            {!! Form::date('filter_date', $datetime->format('Y-m-d'),[]) !!}
        </div>
        <div class="px-1">
            {!! Form::submit('更新', null) !!}
        </div>
    </div>
    {!! Form::close() !!}
    
    
    <hr>
    
    @if (count($reservations) > 0)
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>製品名</th>
                    <th>カテゴリー名</th>
                    <th>貸出開始</th>
                    <th>貸出終了</th>
                    @if($datetime>$today)
                        <th>削除</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->equipment->name }}</td>
                    <td>{{ $reservation->equipment->category->name }}</td>
                    <td>{{ $reservation->lending_start }}</td>
                    <td>{{ $reservation->lending_end }}</td>
                    @if($datetime>$today)
                    <td>
                        {{-- カテゴリー削除ボタンのフォーム --}}
                        {!! Form::open(['route' => ['reservations.destroy', $reservation->id], 'method' => 'delete', ]) !!}
                            {!! Form::hidden('page',0) !!}
                            <input type="image" src="{{asset('image/batsu.png')}}" width="20" height="20">
                        {!! Form::close() !!}
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ページネーションのリンク --}}
        {{ $reservations->links() }}
    @else
        <p class="text-center py-5">貸出予約はありません</p>
    @endif

@endsection