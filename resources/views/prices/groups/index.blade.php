@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_price_groups') }}</h2>
	<table>
		<tr>
			<th>{{ trans('id') }}</th>
			<th>{{ trans('title') }}</th>
			<th>{{ trans('description') }}</th>
		</tr>
		@foreach($groups as $group)
		<tr>
			<td>{{ $group->id }}</td>
			<td>{{ $group->title }}</td>
			<td>{{ $group->description }}</td>
		</tr>
		@endforeach
	</table>
@stop