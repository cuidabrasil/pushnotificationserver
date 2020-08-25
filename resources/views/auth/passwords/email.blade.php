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
            <p class="login-box-msg">{{ trans('auth.enter_email_to_reset_password') }}</p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="post" action="{{ url('/password/email') }}">
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

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">
                            <i class="fa fa-btn fa-envelope"></i> {{ trans('auth.send_password_reset_link') }}
                        </button>
                    </div>
                </div>

            </form>

        </div>
        <!-- /.login-box-body -->
        <p style="margin-top: 10px;font-size: 0.85em;text-align: right;">Desenvolvido por: <a href="{{ trans('project.urlDeveloper') }}" style="cursor: pointer;">{{ trans('project.Developer') }}</a></p>
    </div>
    <!-- /.login-box -->
</div>