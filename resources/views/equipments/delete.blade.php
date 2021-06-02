@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>備品削除</h1>
        <p>
           備品を削除すると、関連する貸出予約状況も削除されます。<br>
           本当に削除しますか？
        </p> 
    </div>
    
    <table class="table table-striped">
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
    
    <div class="col-sm-6 offset-sm-3">
        {{-- カテゴリー削除ボタンのフォーム --}}
        {!! Form::open(['route' => ['equipments.destroy'], 'method' => 'delete', 'id' => 'destroyForm']) !!}
        {!! Form::submit('削除', ['class' => "btn btn-primary btn-block btn-sm"]) !!}
    </div>
    
@endsection