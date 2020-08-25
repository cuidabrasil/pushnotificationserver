@extends('layouts.app')
@section('htmlheader_title')
{{ trans('auth.login_in') }}
@endsection

@section('content')
<style>
    body {
        background-size: 100% !important;
        background-color: #d2d6de !important;
        height: auto !important; 
        min-height: initial !important;
    }
    .login-page, .register-page {
        background: none !important;
    }
    .login-box, .register-box {
        margin: 1% auto 2% auto !important;
    }
</style>
<div class="hold-transition login-page"> 
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ url('/') }}/public/images/logo.png" style="max-width: 75px;">
        </div>
        <div class="login-logo">
            <a href="{{ url('/dashboard') }}"><b>{{ env('APP_NAME') }}</b> {{ env('APP_TITLE') }}</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('auth.sign_in_to_start_your_session') }}</p>

            <form method="post" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="{{ trans('auth.password') }}" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif

                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember">&nbsp;{{ trans('auth.remember_me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('auth.sign_in') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{ url('/password/reset') }}">{{ trans('auth.i_forgot_my_password') }}</a><br>

        </div>
        <!-- /.login-box-body -->
        <p style="margin-top: 10px;font-size: 0.85em;text-align: right;">Desenvolvido por: <a href="{{ trans('project.urlDeveloper') }}" style="cursor: pointer;">{{ trans('project.Developer') }}</a></p>

        <div class="row">
            <div class="col-xs-8">
                <img src="{{ url('/') }}/public/images/umc-logo.png" style="max-width: 205px;margin-top: 30px;">
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <img src="{{ url('/') }}/public/images/logo-branco.png" style="max-width: 140px;margin-top: 20px;">
            </div>
            <!-- /.col -->
        </div>

    </div>
    <!-- /.login-box -->
</div>