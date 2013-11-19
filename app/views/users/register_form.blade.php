{{ Form::open(array('url'=>'users/create', 'class'=>'')) }}
<h2>Register</h2>

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

@if($errors->has('password_confirmation'))
  <div class="error">
    {{ Form::password('password_confirmation', null, array('class'=>'input-required error', 'placeholder'=>'Confirm Password')) }}<small>{{ $errors->first('password_confirmation') }}</small>
  </div>
@else
  {{ Form::password('password_confirmation', array('class'=>'input-required', 'placeholder'=>'Confirm Password')) }}
@endif

@if($errors->has('email'))
  <div class="error">
    {{ Form::text('email', null, array('class'=>'input-optional error', 'placeholder'=>'Email (Optional)')) }}<small>{{ $errors->first('email') }}</small>
  </div>
@else
  {{ Form::text('email', null, array('class'=>'input-optional', 'placeholder'=>'Email (Optional)')) }}
@endif

{{ Form::submit('Register', array('class'=>'button'))}}

{{ Form::close() }}