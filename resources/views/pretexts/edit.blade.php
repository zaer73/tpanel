@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('pre-texts.update', ['id' => $pretext->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<textarea name="text">{{ $pretext->text }}</textarea>
		<select name="group_id">
			@foreach($pre_text_groups as $group)
			<option value="{{ $group->id }}" {{ selected($group->id == $pretext->group_id) }}>
				{{ $group->title }}
			</option>
			@endforeach
		</select>
		<button type="submit">submit</button>
	</form>

	{{ dump($errors) }}
@stop