@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('charges.store') }}">
		{{ csrf_field() }}
		<input type="text" name="code" placeholder="code" value="{{ str_random(8) }}"><br>
		<input type="text" name="credit" placeholder="credit"><br>
		<input type="date" name="expires_at"><Br>
		<button type="submit">submit</button>
	</form>
@stop