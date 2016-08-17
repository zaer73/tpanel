@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_lines_index') }}</h2>
	<table>
		<tr>
			<th>{{ trans('lines_id') }}</th>
			<th>{{ trans('lines_number') }}</th>
			<th>{{ trans('agent') }}</th>
			<th>{{ trans('lines_agent_expiration') }}</th>
			<th>{{ trans('user') }}</th>
			<th>{{ trans('lines_user_expiration') }}</th>
			<th>{{ trans('lines_delete') }}</th>
		</tr>
		@foreach($lines as $line)
		<tr>
			<td>{{ $line->id }}</td>
			<td>{{ $line->number }}</td>
			<td>
				@if($line->agent)
					{{ $line->agent->username }}
				@endif
			</td>
			<td>
				{{ jalali($line->agent_expires_at) }}
			</td>
			<td>
				@if($line->user)
					{{ $line->user->username }}
				@endif
			</td>
			<td>
				{{ jalali($line->user_expires_at) }}
			</td>
			<td>
				<form method="post" action="{{ route('lines.destroy', ['id' => $line->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">{{ trans('lines_delete') }}</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop