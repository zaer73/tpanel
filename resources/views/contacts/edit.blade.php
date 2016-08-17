@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('contacts.contact.update', ['id' => $contact->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<label>group</label>
		<select name="group_id">
			@foreach($groups as $group)
			<option value="{{ $group->id }}" {{ selected($group->id == $contact->group_id) }}>{{ $group->title }}</option>
			@endforeach
		</select><br>
		<input type="text" name="name" placeholder="name" value="{{ $contact->name }}"><br>
		<input type="text" name="number" placeholder="number" value="{{ $contact->number }}"><br>
		<input type="text" name="description" placeholder="description" value="{{ $contact->description }}"><Br>
		<button type="submit">submit</button>
	</form>

	{{ dump($errors) }}
@stop	