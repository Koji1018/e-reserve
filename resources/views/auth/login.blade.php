@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>ログイン</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3 border border-dark py-3 px-5 mt-3">

            {!! Form::open(['route' => 'login.post']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'ユーザ名') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'パスワード') !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-6 offset-sm-3">
                    {!! Form::submit('ログイン', ['class' => 'btn btn-primary btn-block']) !!}
                </div>
            {!! Form::close() !!}
        </div>
        <div class="col-sm-6 offset-sm-3">
        {{-- ユーザ登録ページへのリンク --}}
            <p class="mt-2">{!! link_to_route('signup.get', 'Create an Account') !!}</p>
        </div>
    </div>
@endsection