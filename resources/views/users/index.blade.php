@extends('layouts.app')

@section('content')

    <h1>ユーザ一覧</h1>
    
    <hr>

    {{-- 検索用のフォーム --}}
    {!! Form::open(['route' => ['users.search'], 'method' => 'get']) !!}
    <div class="form-group d-flex row mt-3">
        <div>
            {!! Form::text('name', null,) !!}
        </div>
        <div class="offset-1">
            {!! Form::submit('検索', null) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if (count($users) > 0)
        <table class="table table-striped table-bordered">
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