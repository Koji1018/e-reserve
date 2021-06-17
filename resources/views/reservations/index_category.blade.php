@extends('layouts.app')

@section('content')

    {{-- フィルタ用のフォーム --}}
    {!! Form::model($datetime,['route' => ['reservations.filter_index_category', $id], 'method' => 'get']) !!}
    <h2>
        <div class="row d-flex ">
            <div class="col-12 col-md-4">{!! Form::select('category', $category, $id,) !!}</div>
            <div class="col-12 col-md-2">の貸出状況</div>
        </div>
    </h2>
    
    <div class="form-group d-flex flex-row mt-3">
        <div>
            {!! Form::date('filter_date', $datetime->format('Y-m-d'),[]) !!}
        </div>
        <div class="px-3">
            {!! Form::submit('更新', null) !!}
        </div>
    </div>
    {!! Form::close() !!}

    <hr>
    
    <p>区分：<font size="5">□</font> 貸出可能　<font color="red">■</font> 貸出予約済</p>
    <div class="table-responsive" style="width:100%;overflow:auto; max-height:600px;">
    <table class="table table-striped table-bordered text-center">
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
                <th>{{ $equipment->name }}</th>
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
    </div>
    
    
    {{-- ページネーションのリンク --}}
    {{ $equipments->appends(request()->query())->links() }}

@endsection