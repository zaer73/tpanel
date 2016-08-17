@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('marketing-codes.update', ['id' => $code->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="code" placeholder="code" value="{{ $code->code }}" disabled="disabled"><br>
		<input type="text" name="user_credit" placeholder="user credit" value="{{ $code->user_credit }}"><br>
		<input type="text" name="client_credit" placeholder="client credit" value="{{ $code->client_credit }}"><br>
		<input type="text" name="user_id" placeholder="user id" value="{{ $code->user_id }}"><br>
		<button type="submit">submit</button>
	</form>
	{{ dump($errors) }}
@stop