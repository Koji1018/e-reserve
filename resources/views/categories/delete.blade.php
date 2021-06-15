@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>カテゴリー削除</h1>
        <p class="mt-3">
           カテゴリーを削除すると、関連する備品、貸出予約状況も削除されます。<br>
           本当に削除しますか？
        </p> 
    </div>
    
    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>カテゴリー名</th>
                <th>備品数</th>
                <th>貸出予約件数</th>
            </tr>
        </thead>
        <tbody>
            <!-- {!! $count = 0 !!} -->
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->equipments_count }}台</td>
                    @if( $category->r_total == 0 )
                        <td>{{ $category->r_total }}件</td>
                    @else
                        <td style="color:red">{{ $category->r_total }}件</td>
                    @endif
                    {!! Form::hidden('category['. $count++. ']', $category->id, ['form' => "destroyForm",]) !!}
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="col-sm-6 offset-sm-3">
        {{-- カテゴリー削除ボタンのフォーム --}}
        {!! Form::open(['route' => ['categories.destroy'], 'method' => 'delete', 'id' => 'destroyForm']) !!}
        <div class="col-sm-6 offset-sm-3">
            {!! Form::submit('削除', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
        </div>
        {!! Form::close() !!}
    </div>

@endsection