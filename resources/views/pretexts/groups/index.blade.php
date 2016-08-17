@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>title</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
		@foreach($groups as $group)
		<tr>
			<td>{{ $group->title }}</td>
			<td>
				<a href="{{ route('pre-texts.group.edit', ['id' => $group->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('pre-texts.group.destroy', ['id' => $group->id]) }}">
					{{ csrf_field() }} 
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop