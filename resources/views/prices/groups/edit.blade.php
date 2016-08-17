@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_price_group_edit') }}</h2>

	<form method="post" action="{{ route('price-group.update', ['id' => $group->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $group->title }}"><br>
		<input type="text" name="description" placeholder="desc" value="{{ $group->description }}"><br>
		@foreach(Cons::$price_groups as $p_group)
		<input type="text" name="{{ $p_group }}" placeholder="{{ $p_group }}" value="{{ $group->{$p_group} }}"><br>
		@endforeach
		<button type="submit">{{ trans('price_group_create_submit') }}</button>
	</form>
@stop