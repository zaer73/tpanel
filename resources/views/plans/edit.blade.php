@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('plans.update', ['id' => $plan->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $plan->title }}"><br>
		<input type="text" name="description" placeholder="description" value="{{ $plan->description }}"><Br>
		<select name="line_id">
			@foreach($lines as $line)
			<option value="{{ $line->id }}" {{ selected($line->id == $plan->line_id) }}>
				{{ $line->number }}
			</option>
			@endforeach
		</select><Br>
		<select name="permission_group">
			@foreach($permission_groups as $permission_group)
			<option value="{{ $permission_group->id }}" {{ selected($permission_group->id == $plan->permission_group) }}>
				{{ $permission_group->title }}
			</option>
			@endforeach
		</select><br>
		<select name="price_group">
			@foreach($price_groups as $price_group)
			<option value="{{ $price_group->id }}" {{ selected($price_group->id == $plan->price_group) }}>
				{{ $price_group->title }}
			</option>
			@endforeach
		</select><br>
		<input type="text" name="value" placeholder="value" value="{{ $plan->value }}"><br>
		<button type="submit">submit</button>
	</form>

	@if(count($errors))
	{{ dump($errors) }}
	@endif
@stop