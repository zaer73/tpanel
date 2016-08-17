@extends('layouts.master')

@section('body')
	<h2>{{ trans('title_edit_news') }}</h2>

	<form method="post" action="{{ route('news.update', ['id' => $new->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $new->title }}"><br>
		<textarea name="body">{{ $new->body }}</textarea>
		<label for="everybody">everybody</label>
		<input type="radio" name="target" value="0" id="everybody" {{ checkbox($new->target == 0) }}>
		<label for="agents">agents</label>
		<input type="radio" name="target" value="1" id="agents" {{ checkbox($new->target == 1) }}><br>
		<button type="submit">Edit</button>
	</form>

	<form method="post" action="{{ route('news.destroy', ['id' => $new->id]) }}">
		{{ csrf_field() }}
		{{ method_field('DELETE') }}
		<button type="submit">delete</button>
	</form>
@stop