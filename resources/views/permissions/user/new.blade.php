@extends('layouts.master')

@section('body')
	<h2>{{ trans('permission_user_title', ['username' => $user->username]) }}</h2>

	<form method="post" action="{{ route('permissions.user.update', ['id' => $user->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		@foreach(Cons::$permissions as $permission)
		<label>{{ trans('permission_' . $permission) }}</label>
		<input type="checkbox" 
			name="{{ $permission }}" 
			value="1"
			{{ checkbox($user->permissions->{$permission}) }}
		>
		<br>
		@endforeach
		<button type="submit">{{ trans('permission_user_submit') }}</button>
	</form>

	<form method="post" action="{{ route('permissions.user.group', ['id' => $user->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<select name="group">
		@foreach($permission_groups as $group)
			<option value="{{ $group->id }}">
				{{ $group->title }}
			</option>
		@endforeach
		</select>
		<button type="submit">{{ trans('permission_user_submit') }}</button>
	</form>
@stop