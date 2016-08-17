@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_new_line') }}</h2>

	<form method="post" action="{{ route('lines.store') }}">
		{{ csrf_field() }}
		<input type="text" name="number" placeholder="{{ trans('lines_number') }}">
		<input type="text" name="value" placeholder="{{ trans('lines_value') }}">
		<button type="submit">{{ trans('lines_submit_create') }}</button>
	</form>
@stop