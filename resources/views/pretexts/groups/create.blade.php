@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('pre-texts.group.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title">
		<button type="submit">submit</button>
	</form>
@stop