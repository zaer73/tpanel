@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('marketing-codes.store') }}">
		{{ csrf_field() }}
		<input type="text" name="code" placeholder="code" value="{{ str_random(8) }}"><br>
		<input type="text" name="user_credit" placeholder="user credit"><br>
		<input type="text" name="client_credit" placeholder="client credit"><br>
		<input type="text" name="user_id" placeholder="user id"><br>
		<button type="submit">submit</button>
	</form>
	{{ dump($errors) }}
@stop