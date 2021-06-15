@extends('layouts.app')

@section('content')

    <h1>カテゴリー一覧</h1>
    
    <div class="row mt-3">
        <div class="col-sm-2">
            {{-- カテゴリー追加ボタンのフォーム --}}
            {!! Form::open(['route' => ['categories.create'], 'method' => 'get']) !!}
                {!! Form::submit('追加', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
            {!! Form::close() !!}
        </div>
        
        <div class="col-sm-2">
            {{-- カテゴリー削除ボタンのフォーム --}}
            {!! Form::open(['route' => ['categories.delete'], 'method' => 'get', 'id' => 'deleteForm',]) !!}
                {!! Form::submit('削除', ['class' => "btn btn-secondary btn-block btn-sm", 'id' => "delete", 'disabled']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    
    <hr>

    @if (count($categories) > 0)
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkAll">
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
                        <div class="form-check">
                            <input class="form-check-input checks" type="checkbox" value="{{$category->id}}" id="category[{{$category->id}}]" name="category[{{$category->id}}]" form="deleteForm">
                        </div>
                    </td>
                    <td>
                        <label class="form-check-label" for="category[{{$category->id}}]">
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