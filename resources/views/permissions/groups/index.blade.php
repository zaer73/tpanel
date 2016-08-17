@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_permissions_group') }}</h2>
	<table>
		<tr>
			<th>{{ trans('permission_group_title') }}</th>
			<th>{{ trans('permission_group_desc') }}</th>
			<th>{{ trans('edit') }}</th>
		</tr>
	@foreach($groups as $group)
		<tr>
			<td>{{ $group->title }}</td>
			<td>{{ $group->description }}</td>
			<td>
				<a href="{{ route('permissions.groups.edit', ['id' => $group->id]) }}">{{ trans('edit') }}</a>
			</td>
		</tr>
	@endforeach
	</table>
@stop