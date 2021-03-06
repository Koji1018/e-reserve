@extends('layouts.app')

@section('content')

    <h1>備品一覧</h1>
    
    <div class="row mt-3">
        <div class="col-4 col-md-2">
            {{-- 備品追加ボタンのフォーム --}}
            {!! Form::open(['route' => ['equipments.create'], 'method' => 'get']) !!}
                {!! Form::submit('追加', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
            {!! Form::close() !!}
        </div>
        
        <div class="col-4 col-md-2">
            {{-- 備品削除ボタンのフォーム --}}
            {!! Form::open(['route' => ['equipments.delete'], 'method' => 'get', 'id' => 'deleteForm',]) !!}
                {!! Form::submit('削除', ['class' => "btn btn-secondary btn-block btn-sm", 'id' => "delete", 'disabled']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    
    <hr>
    
    <div class="row my-3">
        {!! Form::open(['route' => ['equipments.search'], 'method' => 'get']) !!}
        <div class="d-flex">
            {{-- カテゴリーのフィルタ --}}
            <div>
                {!! Form::label('category', 'カテゴリー：') !!}
            </div>
            <div class="col-8 col-md-4">
                {!! Form::select('category', $category, null,) !!}
            </div>
        </div>
        <div class="d-flex">
            {{-- 検索用のフォーム --}}
            <div>
                {!! Form::text('name', null,) !!}
            </div>
            <div class="px-3">
                {!! Form::submit('検索', null) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    
    
    
    @if (count($equipments) > 0)
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkAll">
                        </div>
                    </td>
                    <th>製品名</th>
                    <th>カテゴリー名</th>
                    <th>ステータス</th>
                    <th>編集</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipments as $equipment)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input checks" type="checkbox" value="{{$equipment->id}}" id="equipment[{{$equipment->id}}]" name="equipment[{{$equipment->id}}]" form="deleteForm">
                        </div>
                    </td>
                    <td>
                        <label class="form-check-label" for="equipment[{{$equipment->id}}]">
                            {{ $equipment->name }}
                        </label>
                    </td>
                    <td>{{ $equipment->category->name }}</td>
                    @if($equipment->status == 0)
                        <td>貸出可能</td>
                    @elseif($equipment->status == 1)
                        <td style="color:red">貸出不可</td>
                    @else
                    @endif
                    <td>
                        <a href="{{ route('equipments.edit', ['equipment' => $equipment->id]) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ページネーションのリンク --}}
        {{ $equipments->appends(request()->query())->links() }}
    @endif

@endsection