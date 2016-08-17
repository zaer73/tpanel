@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('autoreplies.update', ['id' => $autoreply->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $autoreply->title }}"><br>
		<select name="line_id">
			@foreach($lines as $line)
			<option value="{{ $line->id }}" {{ selected($autoreply->line_id == $line->id) }}>{{ $line->number }}</option>
			@endforeach
		</select><br>
		<select name="condition_type">
			<option value="1" {{ selected($autoreply->condition_type == 1) }}>anything</option>
			<option value="2" {{ selected($autoreply->condition_type == 2) }}>contains</option>
		</select><br>
		<input type="text" name="condition_text" placeholder="condition text" value="{{ $autoreply->condition_text }}"><br>
		<select name="reaction_type">
			<option value="1" {{ selected($autoreply->reaction_type == 1) }}>add to group</option>
			<option value="2" {{ selected($autoreply->reaction_type == 2) }}>remove from group (if participated)</option>
			<option value="3" {{ selected($autoreply->reaction_type == 3) }}>send reply</option>
		</select><br>
		<select name="reaction_group">
			@foreach($groups as $group)
			<option value="{{ $group->id }}" {{ selected($autoreply->reaction_group == $group->id) }}>{{ $group->title }}</option>
			@endforeach
		</select><br>
		<input type="text" name="reaction_text" placeholder="reaction reply text" value="{{ $autoreply->reaction_text }}"><br>
		<button type="submit">submit</button>
	</form>

	@if(count($errors))
		{{ dump($errors) }}
	@endif
@stop