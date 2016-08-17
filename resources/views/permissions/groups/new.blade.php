@extends('layouts.master')

@section('body')
@if(session('status'))
	{{ session('status') }}
@endif
<h2>{{ trans('title_new_permission_group') }}</h2>
<form method="post" action="{{ route('permissions.groups.store') }}">
	{{ csrf_field() }}
	<input type="text" name="title" placeholder="{{ trans('permission_group_title') }}"><br>
	<input type="text" name="description" placeholder="{{ trans('permission_group_desc') }}"><br>

	@foreach(Cons::$permissions as $permission)
	<label>{{ trans('permission_' . $permission) }}</label>
	<input type="checkbox" name="{{ $permission }}" value="1"><br>
	@endforeach
	
	<button type="submit">{{ trans('permission_group_submit') }}</button>
</form>
@stop