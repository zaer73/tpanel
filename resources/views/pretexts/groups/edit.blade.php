@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('pre-texts.group.update', ['id' => $group->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $group->title }}">
		<button type="submit">submit</button>
	</form>
@stop