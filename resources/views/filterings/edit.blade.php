@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('filterings.update', ['id' => $filtering->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="filtering_key" placeholder="filtering key" value="{{ $filtering->filtering_key }}"><br>
		<button type="submit">submit</button>
	</form>

@stop