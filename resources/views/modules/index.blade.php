@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>module_key</th>
			<th>value</th>
			<td>edit</td>
			<td>delete</td>
		</tr>
	@foreach($modules as $module)
		<tr>
			<td>{{ trans('permission_'.$module->module_key) }}</td>
			<td>{{ $module->value }}</td>
			<td>
				<a href="{{ route('modules.edit', ['id' => $module->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('modules.destroy', ['id' => $module->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>
@stop