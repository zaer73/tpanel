@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('polls.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title"><br>
		<select name="type">
			<option value="1">nazar</option>
			<option value="2">mosabeghe</option>
		</select><br>
		<select name="line_id">
		@if($lines)
			@foreach($lines as $line)
				<option value="{{ $line->id }}">{{ $line->number }}</option>
			@endforeach
		@endif
		</select><br>
		<input type="date" name="started_at"><br>
		<input type="date" name="finished_at"><br>
		<input type="text" name="question" placeholder="question"><Br>
		<input type="text" name="answer" placeholder="answer"><br>
		<input type="text" name="reply" placeholder="reply"><br>
		<button type="submit">submit</button>
	</form>
	{{ dump($errors) }}
@stop