@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-md-offset-3 col-md-6">

        <h1>Forgot Password</h1>

        {{ Form::open(array('url' => URL::to('/users/forgot_password'))) }}

            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

            <div class="form-group">
                <label for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>
                <div class="input-append input-group">
                    <input
                        class="form-control"
                        placeholder="{{{ Lang::get('confide::confide.e_mail') }}}"
                        type="text"
                        name="email"
                        id="email"
                        value="{{{ Input::old('email') }}}">
                    <span class="input-group-btn">
                        <input
                            class="btn btn-primary"
                            type="submit"
                            value="{{{ Lang::get('confide::confide.forgot.submit') }}}">
                    </span>
                </div>
            </div>

            @if (Session::get('error'))
                <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
            @endif

            @if (Session::get('notice'))
                <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
            @endif

        {{ Form::close() }}

    </div>

</div>

@stop