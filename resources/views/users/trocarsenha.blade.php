@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($user, ['route' => ['users.trocarsenha_gravar', $id], 'method' => 'patch']) !!}

                        <!-- Password Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! Form::hidden('tipo', $tipo, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Gravar', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('users.index') !!}" class="btn btn-default">{{ trans('dashboard.cancel') }}</a>
                        </div>

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection