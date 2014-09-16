@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-md-offset-3 col-md-6">

        <h1>Login to Bet Tracker</h1>

        {{ Form::open(array('url' => URL::to('/users/login'))) }}

            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

            <fieldset>
                <div class="form-group">
                    <label for="email">{{{ Lang::get('confide::confide.username_e_mail') }}}</label>
                    <input
                        class="form-control"
                        tabindex="1"
                        placeholder="{{{ Lang::get('confide::confide.username_e_mail') }}}"
                        type="text"
                        name="email"
                        id="email"
                        value="{{{ Input::old('email') }}}">
                </div>
                <div class="form-group">
                    <label for="password">
                        {{{ Lang::get('confide::confide.password') }}}
                        <small>
                            <a href="{{{ URL::to('/users/forgot_password') }}}">
                                {{{ Lang::get('confide::confide.login.forgot_password') }}}
                            </a>
                        </small>
                    </label>
                    <input
                        class="form-control"
                        tabindex="2"
                        placeholder="{{{ Lang::get('confide::confide.password') }}}"
                        type="password"
                        name="password"
                        id="password">
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label for="remember" class="checkbox">
                            <input type="hidden" name="remember" value="0">
                            <input class="pull-right" tabindex="4" type="checkbox" name="remember" id="remember" value="1">
                            {{{ Lang::get('confide::confide.login.remember') }}}
                        </label>
                    </div>
                </div>

                @if (Session::get('error'))
                    <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
                @endif

                @if (Session::get('notice'))
                    <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
                @endif

                <div class="form-group">
                    <button
                        tabindex="3"
                        type="submit"
                        class="btn btn-primary">
                        {{{ Lang::get('confide::confide.login.submit') }}}
                    </button>
                </div>

            </fieldset>

        {{ Form::close() }}
    
    </div>

</div>

@stop