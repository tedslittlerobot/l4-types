@extends('l4-fields::layout')

@section('content')

	{{ Form::open() }}

		<fieldset>

			<legend>Create {{ ucwords( $type->slug() ) }}:</legend>

			@foreach ( $errors->get('title') as $error )
				<div class="danger alert">{{ $error }}</div>
			@foreach
			<div class="field">
				{{ Form::text('title', null, ['class' => 'input', 'placeholder' => 'Title']) }}
			</div>

			@foreach ( $errors->get('slug') as $error )
				<div class="danger alert">{{ $error }}</div>
			@foreach
			<div class="field">
				{{ Form::text('slug', null, ['class' => 'input', 'placeholder' => 'Slug']) }}
			</div>

			@include( Config::get('types.types.default.' . $type . '.fields') )

			<div class="medium primary btn">
				{{ Form::submit() }}
			</div>

		</fieldset>

	{{ Form::close() }}

@stop
