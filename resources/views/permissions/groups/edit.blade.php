@extends('layouts.master')

@section('body')
@if(session('status'))
	{{ session('status') }}
@endif
<h2>{{ trans('title_edit_permission_group') }}</h2>
<form method="post" action="{{ route('permissions.groups.update', ['id' => $group->id]) }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<input type="text" 
		name="title" 
		placeholder="{{ trans('permission_group_title') }}" 
		value="{{ $group->title }}"
	><br>

	<input type="text" 
		name="description" 
		placeholder="{{ trans('permission_group_desc') }}"
		value="{{ $group->description }}"><br>

	@foreach(Cons::$permissions as $permission)
	<label>{{ trans('permission_' . $permission) }}</label>
	<input type="checkbox" 
		name="{{ $permission }}" 
		value="1" 
		{{ checkbox($group->$permission) }}
	><br>
	@endforeach

	<button type="submit">{{ trans('permission_group_submit') }}</button>
</form>
@stop