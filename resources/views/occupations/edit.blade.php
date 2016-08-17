@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('occupations.update', ['id' => $occupation->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $occupation->title }}">
		<button type="submit">update</button>
	</form>
@stop