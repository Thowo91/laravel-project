<div class="form-group">
    {{ Form::label('name', 'Name') }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}
    <div>{{ $errors->first('name') }}</div>
</div>
{{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
