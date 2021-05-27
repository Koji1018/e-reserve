@extends('layouts.app')

@section('content')

    <h1>カテゴリー一覧</h1>
    
    <div class="row">
        <div class="col-sm-2">
            {{-- カテゴリー追加ボタンのフォーム --}}
            {!! Form::open(['route' => ['categories.create'], 'method' => 'get']) !!}
                {!! Form::submit('追加', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
            {!! Form::close() !!}
        </div>
        
        <div class="col-sm-2">
            {{-- カテゴリー削除ボタンのフォーム --}}
            {!! Form::open(['route' => ['admin.add'], 'method' => 'get']) !!}
                {!! Form::submit('削除', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
            {!! Form::close() !!}
        </div>
    </div>

    @if (count($categories) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>
                        <div class="form-check", "text-center">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        </div>
                    </td>
                    <th>カテゴリー名</th>
                    <th>編集</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>
                        <div class="form-check", "text-center">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault{{$category->id}}">
                        </div>
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckDefault{{$category->id}}">
                            {{ $category->name }}
                        </label>
                    </td>
                    <td>
                        <a href="{{ route('categories.edit', ['category' => $category->id]) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ページネーションのリンク --}}
        {{ $categories->links() }}
    @endif

@endsection