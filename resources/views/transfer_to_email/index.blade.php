@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>number</th>
			<th>email</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
	@foreach($transfers as $transfer)
		<tr>
			<td>{{ $transfer->number }}</td>
			<td>{{ $transfer->email }}</td>
			<td>
				<a href="{{ route('transfer-to-email.edit', ['id' => $transfer->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('transfer-to-email.destroy', ['id' => $transfer->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>
@stop