
@foreach ( $errors->get('body') as $error )
	<div class="danger alert">{{ $error }}</div>
@foreach
<div class="field">
	{{ Form::textarea('body', null, ['class' => 'input textarea']) }}
</div>
