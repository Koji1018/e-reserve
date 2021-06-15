@extends('layouts.app')

@section('content')

    <h1>ユーザ一覧</h1>
    
    <hr>

    {{-- 検索用のフォーム --}}
    {!! Form::open(['route' => ['users.search'], 'method' => 'get']) !!}
        {!! Form::text('name', null,) !!}
        {!! Form::submit('検索', null) !!}
    {!! Form::close() !!}

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
        {{ $users->appends(request()->query())->links() }}
    @endif

@endsection