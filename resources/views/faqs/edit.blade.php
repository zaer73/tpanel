@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('faqs.update', ['id' => $faq->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<textarea name="question">{{ $faq->question }}</textarea><br>
		<textarea name="answer">{{ $faq->answer }}</textarea><br>
		<button type="submit">submit</button>
	</form>
@stop