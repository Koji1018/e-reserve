@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>備品削除</h1>
        <p class="mt-3">
           備品を削除すると、関連する貸出予約状況も削除されます。<br>
           本当に削除しますか？
        </p> 
    </div>
    
    <table class="table table-striped table-bordered text-center">
        <thead>
            <tr>
                <th>製品名</th>
                <th>カテゴリー名</th>
                <th>貸出予約</th>
            </tr>
        </thead>
        <tbody>
            <!-- {!! $count = 0 !!} -->
            @foreach ($equipments as $equipment)
                <tr>
                    <td>{{ $equipment->name }}</td>
                    <td>{{ $equipment->category->name }}</td>
                    @if( $equipment->reserve_users_count == 0 )
                        <td>無</td>
                    @else
                        <td style="color:red">有</td>
                    @endif
                    {!! Form::hidden('equipment['. $count++. ']', $equipment->id, ['form' => "destroyForm",]) !!}
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="col-4 offset-4 offset-md-5 col-md-2">
        {{-- カテゴリー削除ボタンのフォーム --}}
        {!! Form::open(['route' => ['equipments.destroy'], 'method' => 'delete', 'id' => 'destroyForm']) !!}
        {!! Form::submit('削除', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
        {!! Form::close() !!}
    </div>
    
@endsection