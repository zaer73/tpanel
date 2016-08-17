@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>title</th>
			<th>description</th>
			<th>type</th>
			<th>texts</th>
			<th>value</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
	@foreach($specials as $special)
		<tr>
			<td>{{ $special->title }}</td>
			<td>{{ str_limit($special->description,200) }}</td>
			<td>{{ $special->type }}</td>
			<td>{{ $special->texts }}</td>
			<td>{{ $special->value }}</td>
			<td>
				<a href="{{ route('specials.edit', ['id' => $special->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('specials.destroy', ['id' => $special->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>
@stop