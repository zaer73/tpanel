@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('polls.update', ['id' => $poll->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $poll->title }}"><br>
		<select name="type">
			<option value="1" {{ selected($poll->type == 1) }}>nazar</option>
			<option value="2" {{ selected($poll->type == 2) }}>mosabeghe</option>
		</select><br>
		<select name="line_id">
		@if($lines)
			@foreach($lines as $line)
				<option value="{{ $line->id }}" {{ selected($poll->line_id == $line->id) }}>{{ $line->number }}</option>
			@endforeach
		@endif
		</select><br>
	<input type="date" name="started_at" value="{{ date('Y-m-d', strtotime($poll->started_at)) }}"><br>
	<input type="date" name="finished_at" value="{{ date('Y-m-d', strtotime($poll->finished_at)) }}"><br>
	<input type="text" name="question" placeholder="question" value="{{ $poll->question }}"><Br>
	<input type="text" name="answer" placeholder="answer" value="{{ $poll->answer }}"><br>
	<input type="text" name="reply" placeholder="reply" value="{{ $poll->reply }}"><br>
		<button type="submit">submit</button>
	</form>
	{{ dump($errors) }}
@stop