<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $user->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('type', 'Tipo:') !!}
    <p>{!! ucwords($user->type) !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nome:') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'E-mail:') !!}
    <p>{!! $user->email !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Data de Criação:') !!}
    <p>{{ !is_null($user->created_at) ? date_format(date_create($user->created_at),"d/m/Y H:i") : null }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Data de Alteração:') !!}
    <p>{{ !is_null($user->updated_at) ? date_format(date_create($user->updated_at),"d/m/Y H:i") : null }}</p>
</div>

