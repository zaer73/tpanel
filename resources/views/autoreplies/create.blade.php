@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('autoreplies.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title"><br>
		<select name="line_id">
			@foreach($lines as $line)
			<option value="{{ $line->id }}">{{ $line->number }}</option>
			@endforeach
		</select><br>
		<select name="condition_type">
			<option value="1">anything</option>
			<option value="2">contains</option>
		</select><br>
		<input type="text" name="condition_text" placeholder="condition text"><br>
		<select name="reaction_type">
			<option value="1">add to group</option>
			<option value="2">remove from group (if participated)</option>
			<option value="3">send reply</option>
		</select><br>
		<select name="reaction_group">
			@foreach($groups as $group)
			<option value="{{ $group->id }}">{{ $group->title }}</option>
			@endforeach
		</select><br>
		<input type="text" name="reaction_text" placeholder="reaction reply text"><br>
		<button type="submit">submit</button>
	</form>

	@if(count($errors))
		{{ dump($errors) }}
	@endif
@stop