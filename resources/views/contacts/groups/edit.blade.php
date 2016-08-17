@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('contacts.groups.update', ['id' => $group->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $group->title }}"><Br>
		<input type="text" name="description" placeholder="description" value="{{ $group->description }}"><br>
		<button type="submit">update</button>
	</form>
@stop