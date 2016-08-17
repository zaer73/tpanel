@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>id</th>
			<th>title</th>
			<th>description</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
	@foreach($groups as $group)
		<tr>
			<td>{{ $group->id }}</td>
			<td>{{ $group->title }}</td>
			<td>{{ $group->description }}</td>
			<td>
				<a href="{{ route('contacts.groups.edit', ['id' => $group->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('contacts.groups.destroy', ['id' => $group->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>
@stop