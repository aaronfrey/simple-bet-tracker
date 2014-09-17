@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-md-offset-3 col-md-6">

        <h1>Reset Password</h1>

        {{ Form::open(array('url' => URL::to('/users/reset_password'))) }}

            <input type="hidden" name="token" value="{{{ $token }}}">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

            <div class="form-group">
                <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
                <input
                    class="form-control"
                    placeholder="{{{ Lang::get('confide::confide.password') }}}"
                    type="password"
                    name="password"
                    id="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">
                    {{{ Lang::get('confide::confide.password_confirmation') }}}
                </label>
                <input
                    class="form-control"
                    placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}"
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation">
            </div>

            @if (Session::get('error'))
                <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
            @endif

            @if (Session::get('notice'))
                <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
            @endif

            <div class="form-actions form-group">
                <button type="submit" class="btn btn-primary">
                    {{{ Lang::get('confide::confide.forgot.submit') }}}
                </button>
            </div>

        {{ Form::close() }}

    </div>

</div>

@stop