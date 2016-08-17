@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('postal-code.update', ['id' => $postal_code->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $postal_code->title }}">
		<button type="submit">update</button>
	</form>
@stop