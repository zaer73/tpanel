@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('filterings.store') }}">
		{{ csrf_field() }}
		<input type="text" name="filtering_key" placeholder="filtering key"><br>
		<button type="submit">submit</button>
	</form>
@stop