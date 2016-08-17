@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('occupations.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title">
		<button type="submit">submit</button>
	</form>
@stop