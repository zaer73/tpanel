@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('faqs.store') }}">
		{{ csrf_field() }}
		<textarea name="question"></textarea><br>
		<textarea name="answer"></textarea><br>
		<button type="submit">submit</button>
	</form>
@stop