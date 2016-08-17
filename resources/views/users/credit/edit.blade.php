@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_user_credit') }}</h2>
	<form method="post" action="{{ route('users.credit.update', ['id' => $user->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="number" name="credit" value="{{ $user->credit }}">
		<button type="submit">{{ trans('user_credit_submit') }}</button>
	</form>

	{{ dump($errors) }}
@stop