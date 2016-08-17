@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>code</th>
			<th>credit</th>
			<th>expired</th>
			<th>created at</th>
			<th>expires at</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
		@foreach($charges as $charge)
		<tr>
			<td>{{ $charge->code }}</td>
			<td>{{ $charge->credit }}</td>
			<td>{{ $charge->expired }}</td>
			<td>{{ jalali($charge->created_at) }}</td>
			<td>{{ jalali($charge->expires_at) }}</td>
			<td>
				<a href="{{ route('charges.edit', ['id' => $charge->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('charges.destroy', ['id' => $charge->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop