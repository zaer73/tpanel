@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('pre-texts.store') }}">
		{{ csrf_field() }}
		<textarea name="text"></textarea>
		<select name="group_id">
			@foreach($pre_text_groups as $group)
			<option value="{{ $group->id }}">
				{{ $group->title }}
			</option>
			@endforeach
		</select>
		<button type="submit">submit</button>
	</form>

	{{ dump($errors) }}
@stop