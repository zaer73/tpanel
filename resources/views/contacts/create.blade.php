@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('contacts.contact.store') }}">
		{{ csrf_field() }}
		<label>group</label>
		<select name="group_id">
			@foreach($groups as $group)
			<option value="{{ $group->id }}">{{ $group->title }}</option>
			@endforeach
		</select><br>
		<input type="text" name="name" placeholder="name"><br>
		<input type="text" name="number" placeholder="number"><br>
		<input type="text" name="description" placeholder="description"><Br>
		<button type="submit">submit</button>
	</form>
@stop	