@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('contacts.groups.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title"><Br>
		<input type="text" name="description" placeholder="description"><br>
		<button type="submit">submit</button>
	</form>
@stop