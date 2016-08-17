@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_lines_index') }}</h2>
	<table>
		<tr>
			<th>{{ trans('lines_id') }}</th>
			<th>{{ trans('lines_number') }}</th>
		</tr>
		@foreach($lines as $line)
		<tr>
			<td>{{ $line->id }}</td>
			<td>{{ $line->number }}</td>
		</tr>
		@endforeach
	</table>
@stop