@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('specials.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title"><br>
		<input type="text" name="description" placeholder="description"><br>
		<input type="text" name="texts" placeholder="texts"><br>
		<input type="text" name="value" placeholder="value"><br>
		<button type="submit">submit</button>
	</form>
@stop