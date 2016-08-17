@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>id</th>
			<th>group</th>
			<th>name</th>
			<th>number</th>
			<th>description</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
	@foreach($contacts as $contact)
		<tr>
			<td>{{ $contact->id }}</td>
			<td>{{ $contact->group->title }}</td>
			<td>{{ $contact->name }}</td>
			<td>{{ $contact->number }}</td>
			<td>{{ str_limit($contact->description, 200) }}</td>
			<td><a href="{{ route('contacts.contact.edit', ['id' => $contact->id]) }}">edit</a></td>
			<td>
				<form method="post" action="{{ route('contacts.contact.destroy', ['id' => $contact->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>
@stop