@extends('layouts.app')

@section('content')

    {{-- フィルタ用のフォーム --}}
    {!! Form::model($datetime,['route' => ['reservations.filter_index_category', $id], 'method' => 'get']) !!}
        <h1>
            <div class="col-sm-9">
                {{-- カテゴリーのフィルタ --}}
                {!! Form::select('category', $category, $id,) !!}
                の貸出状況
            </div>
        </h1>
        <div class="form-group d-flex flex-row">
            {!! Form::date('filter_date', $datetime->format('Y-m-d'),[]) !!}
            {!! Form::submit('更新', null) !!}
        </div>
    {!! Form::close() !!}

    <hr>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>製品名</th>
                @for ($i=0; $i<count($time)-1; $i++)
                    <th>{{ $time[$i] }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            {{ '', $count = 0 }}
            @foreach ($equipments as $equipment)
            <tr>
                <td>{{ $equipment->name }}</td>
                @for ($i=0; $i<count($time)-1; $i++)
                    @if ($reserved_list[$count][$i] != 0) <td bgcolor="red"></td>
                    @else <td></td>
                    @endif
                @endfor
            {{ '', $count++ }}
            @endforeach
            </tr>
            
        </tbody>
    </table>

    {{-- ページネーションのリンク --}}
    {{ $equipments->appends(request()->query())->links() }}

@endsection