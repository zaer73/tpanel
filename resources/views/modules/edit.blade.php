@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('modules.update', ['id' => $module]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="module_key" value="{{ trans('permission_'.$module->module_key) }}" disabled="disabled"><br>
		<input type="text" name="value" placeholder="value" value="{{ $module->value }}"><br>
		<button type="submit">submit</button>
	</form>
@stop	