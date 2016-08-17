@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>number</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
	@foreach($blacklists as $blacklist)
		<tr>
			<td>{{ $blacklist->number }}</td>
			<td>
				<a href="{{ route('blacklist.edit', ['id' => $blacklist->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('blacklist.destroy', ['id' => $blacklist->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>
@stop