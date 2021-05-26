@extends('layouts.app')

@section('content')

    <h1>ユーザ一覧</h1>

    @if (count($users) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ユーザ名</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ページネーションのリンク --}}
        {{ $users->links() }}
    @endif

@endsection