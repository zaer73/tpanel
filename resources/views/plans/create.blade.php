@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('plans.store') }}">
		{{ csrf_field() }}
		<input type="text" name="title" placeholder="title"><br>
		<input type="text" name="description" placeholder="description"><Br>
		<select name="line_id">
			@foreach($lines as $line)
			<option value="{{ $line->id }}">
				{{ $line->number }}
			</option>
			@endforeach
		</select><Br>
		<select name="permission_group">
			@foreach($permission_groups as $permission_group)
			<option value="{{ $permission_group->id }}">
				{{ $permission_group->title }}
			</option>
			@endforeach
		</select><br>
		<select name="price_group">
			@foreach($price_groups as $price_group)
			<option value="{{ $price_group->id }}">
				{{ $price_group->title }}
			</option>
			@endforeach
		</select><br>
		<input type="text" name="value" placeholder="value"><br>
		<button type="submit">submit</button>
	</form>

	@if(count($errors))
	{{ dump($errors) }}
	@endif
@stop