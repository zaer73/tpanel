@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>title</th>
			<th></th>
			<th></th>
		</tr>
		@foreach($postal_codes as $code)
		<tr>
			<td>{{ $code->title }}</td>
			<td><a href="{{ route('postal-code.edit', ['id' => $code->id]) }}">edit</a></td>
			<td>
				<form method="post" action="{{ route('postal-code.destroy', ['id' => $code->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">DELETE</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop	