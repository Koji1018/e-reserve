@extends('layouts.app')

@section('content')

    <h1>管理者一覧</h1>
    
    <div class="row mt-3">
        <div class="col-3 col-md-2">
            {{-- 管理者追加ボタンのフォーム --}}
            {!! Form::open(['route' => ['admin.add'], 'method' => 'get']) !!}
                {!! Form::submit('追加', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
            {!! Form::close() !!}
        </div>
    </div>
    
    <hr>

    @if (count($admins) > 0)
        <table class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th>ユーザ名</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ページネーションのリンク --}}
        {{ $admins->links() }}
    @endif

@endsection