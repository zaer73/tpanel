@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_create_news') }}</h2>

	<form method="post" action="{{ route('news.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title"><br>
		<textarea name="body"></textarea>
		<label for="everybody">everybody</label>
		<input type="radio" name="target" value="0" id="everybody" checked="checked">
		<label for="agents">agents</label>
		<input type="radio" name="target" value="1" id="agents"><br>
		<button type="submit">Send</button>
	</form>
@stop