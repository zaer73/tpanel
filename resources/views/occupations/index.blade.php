@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>title</th>
			<th></th>
			<th></th>
		</tr>
		@foreach($occupations as $occ)
		<tr>
			<td>{{ $occ->title }}</td>
			<td>
				<a href="{{ route('occupations.edit', ['id' => $occ->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('occupations.destroy', ['id' => $occ->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop