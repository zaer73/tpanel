@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('blacklist.store') }}">
		{{ csrf_field() }}
		<input type="text" name="number" placeholder="number"><br>
		<button type="submit">submit</button>
	</form>
@stop