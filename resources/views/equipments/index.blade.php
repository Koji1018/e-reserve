@extends('layouts.app')

@section('content')

    <h1>備品一覧</h1>
    
    @if (count($equipments) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>〇</th>
                    <th>製品名</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipments as $equipment)
                <tr>
                    <td>〇</td>
                    <td>{{ $equipment->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ページネーションのリンク --}}
        {{ $equipments->links() }}
    @endif

@endsection