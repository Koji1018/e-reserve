@extends('layouts.app')

@section('content')

    <h1>備品一覧</h1>
    
    <div class="row">
        <div class="col-sm-2">
            {{-- 備品追加ボタンのフォーム --}}
            {!! Form::open(['route' => ['equipments.create'], 'method' => 'get']) !!}
                {!! Form::submit('追加', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
            {!! Form::close() !!}
        </div>
        
        <div class="col-sm-2">
            {{-- 備品削除ボタンのフォーム --}}
            {!! Form::open(['route' => ['equipments.delete'], 'method' => 'get']) !!}
                {!! Form::submit('削除', ['class' => "btn btn-secondary btn-block btn-sm", 'id' => "delete", 'disabled']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    
    @if (count($equipments) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>
                        <div class="form-check text-center">
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
                        <div class="form-check text-center">
                            <input class="form-check-input checks" type="checkbox" value="" id="Equipment{{$equipment->id}}" name="Equipment[]">
                        </div>
                    </td>
                    <td>
                        <label class="form-check-label" for="Equipment{{$equipment->id}}">
                            {{ $equipment->name }}
                        </label>
                    </td>
                    <td>{{ $equipment->category->name }}</td>
                    <td>
                        @if($equipment->status == 0)貸出可能
                        @elseif($equipment->status == 1) 貸出不可
                        @else
                        @endif
                    </td>
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
        {{ $equipments->links() }}
    @endif

@endsection