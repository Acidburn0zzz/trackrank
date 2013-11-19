{{ Form::open(array('url'=>'users/login', 'class'=>'')) }}
<h2>Login</h2>

@if($errors->has('username'))
  <div class="error">
    {{ Form::text('username', null, array('class'=>'input-required error', 'placeholder'=>'Username')) }}<small>{{ $errors->first('username') }}</small>
  </div>
@else
  {{ Form::text('username', null, array('class'=>'input-required', 'placeholder'=>'Username')) }}
@endif

@if($errors->has('password'))
  <div class="error">
    {{ Form::password('password', null, array('class'=>'input-required error', 'placeholder'=>'Password')) }}<small>{{ $errors->first('password') }}</small>
  </div>
@else
  {{ Form::password('password', array('class'=>'input-required', 'placeholder'=>'Password')) }}
@endif

{{ Form::submit('Login', array('class'=>'button'))}}

{{ Form::close() }}
