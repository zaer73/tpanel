@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_lines_index') }}</h2>
	<table>
		<tr>
			<th>{{ trans('lines_id') }}</th>
			<th>{{ trans('lines_number') }}</th>
			<th>{{ trans('user') }}</th>
			<th>{{ trans('lines_user_expiration') }}</th>
		</tr>
		@foreach($lines as $line)
		<tr>
			<td>{{ $line->id }}</td>
			<td>{{ $line->number }}</td>
			<td>
				@if($line->user)
					{{ $line->user->username }}
				@endif
			</td>
			<td>
				{{ jalali($line->user_expires_at) }}
			</td>
		</tr>
		@endforeach
	</table>
@stop