@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('blacklist.update', ['id' => $blacklist->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="number" placeholder="number" value="{{ $blacklist->number }}"><br>
		<button type="submit">submit</button>
	</form>
@stop