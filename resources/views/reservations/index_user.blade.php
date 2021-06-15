@extends('layouts.app')

@section('content')

    <h1>{{ Auth::user()->name }}さんの予約状況</h1>
    
    <hr>
    
    @if (count($reservations) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>製品名</th>
                    <th>カテゴリー名</th>
                    <th>貸出開始</th>
                    <th>貸出終了</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->equipment->name }}</td>
                    <td>{{ $reservation->equipment->category->name }}</td>
                    <td>{{ $reservation->lending_start }}</td>
                    <td>{{ $reservation->lending_end }}</td>
                    <td>
                        {{-- カテゴリー削除ボタンのフォーム --}}
                        {!! Form::open(['route' => ['reservations.destroy', $reservation->id], 'method' => 'delete', ]) !!}
                            {!! Form::hidden('page',0) !!}
                            <input type="image" src="{{asset('image/batsu.png')}}" width="20" height="20">
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ページネーションのリンク --}}
        {{ $reservations->links() }}
    @else
        <p class="text-center">貸出予約はありません</p>
    @endif

@endsection