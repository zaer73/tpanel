@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_price_group_create') }}</h2>

	<form method="post" action="{{ route('price-group.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title"><br>
		<input type="text" name="description" placeholder="desc"><br>
		@foreach(Cons::$price_groups as $group)
		<input type="text" name="{{ $group }}" placeholder="{{ $group }}" value="1"><br>
		@endforeach
		<button type="submit">{{ trans('price_group_create_submit') }}</button>
	</form>
@stop