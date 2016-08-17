@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('codereaders.update', ['id' => $codereader->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $codereader->title }}"><br>
		<select name="line_id">
			@foreach($lines as $line)
			<option value="{{ $line->id }}" {{ selected($codereader->line_id == $line->id) }}>{{ $line->number }}</option>
			@endforeach
		</select><br>
		<select name="condition_type">
			<option value="2" {{ selected($codereader->condition_type == 2) }}>contains</option>
		</select><br>
		<input type="text" name="condition_text" placeholder="condition text" value="{{ $codereader->condition_text }}"><br>
		<select name="reaction_type">
			<option value="1" {{ selected($codereader->reaction_type == 1) }}>add to group</option>
			<option value="2" {{ selected($codereader->reaction_type == 2) }}>remove from group (if participated)</option>
			<option value="3" {{ selected($codereader->reaction_type == 3) }}>send reply</option>
		</select><br>
		<select name="reaction_group">
			@foreach($groups as $group)
			<option value="{{ $group->id }}" {{ selected($codereader->reaction_group == $group->id) }}>{{ $group->title }}</option>
			@endforeach
		</select><br>
		<input type="text" name="reaction_text" placeholder="reaction reply text" value="{{ $codereader->reaction_text }}"><br>
		<button type="submit">submit</button>
	</form>

	@if(count($errors))
		{{ dump($errors) }}
	@endif
@stop