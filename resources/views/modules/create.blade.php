@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('modules.store') }}">
		{{ csrf_field() }}
		<select name="module_key">
		@foreach($modules as $module_key => $module_value)
			<option value="{{ $module_value }}">
				{{ trans('permission_' . $module_value) }}
			</option>
		@endforeach
		</select><br>
		<input type="text" name="value" placeholder="value"><br>
		<button type="submit">submit</button>
	</form>
@stop	