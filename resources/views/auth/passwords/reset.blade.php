@extends('layouts.app')
@section('htmlheader_title')
{{ trans('auth.reset_your_password') }}
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
</style>
<div class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/dashboard') }}"><b>{{ env('APP_NAME') }}</b> {{ env('APP_TITLE') }}</a>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('auth.reset_your_password') }}</p>

            <form method="post" action="{{ url('/password/reset') }}">
                {!! csrf_field() !!}

                <input type="hidden" name="token" value="{{ $token }}">

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
                    <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="{{ trans('auth.confirm_password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">
                            <i class="fa fa-btn fa-refresh"></i> {{ trans('auth.reset_password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <p style="margin-top: 10px;font-size: 0.85em;text-align: right;">Desenvolvido por: <a href="{{ trans('project.urlDeveloper') }}" style="cursor: pointer;">{{ trans('project.Developer') }}</a></p>
    </div>
</div>