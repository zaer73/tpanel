@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>id</th>
			<th>name</th>
			<th>number</th>
			<th>description</th>
			<th>restore</th>
			<th>destroy</th>
		</tr>
	@foreach($contacts as $contact)
		<tr>
			<td>{{ $contact->id }}</td>
			<td>{{ $contact->name }}</td>
			<td>{{ $contact->number }}</td>
			<td>{{ str_limit($contact->description, 200) }}</td>
			<td>
				<form method="post" action="{{ route('contacts.trash.restore', ['id' => $contact->id]) }}">
					{{ csrf_field() }}
					<button type="submit">restore</button>
				</form>
			</td>
			<td>
				<form method="post" action="{{ route('contacts.trash.explode', ['id' => $contact->id]) }}">
					{{ csrf_field() }}
					<button type="submit">destroy</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>
@stop			