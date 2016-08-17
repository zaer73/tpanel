@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>group</th>
			<th>text</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
		@foreach($pretexts as $pre)
		<tr>
			<td>{{ $pre->group->title }}</td>
			<td>{{ $pre->text }}</td>
			<td>
				<a href="{{ route('pre-texts.edit', ['id' => $pre->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('pre-texts.destroy', ['id' => $pre->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop