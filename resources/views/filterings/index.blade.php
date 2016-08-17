@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>key</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
		@foreach($filterings as $filtering)
		<tr>
			<td>{{ $filtering->filtering_key }}</td>
			<td>
				<a href="{{ route('filterings.edit', ['id' => $filtering->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('filterings.destroy', ['id' => $filtering->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop