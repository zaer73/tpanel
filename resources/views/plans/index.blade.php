@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>title</th>
			<th>line</th>
			<th>permission group</th>
			<th>price group</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
	@foreach($plans as $plan)
		<tr>
			<td>{{ $plan->title }}</td>
			<td>{{ $plan->line->number }}</td>
			<td>{{ $plan->permission_groups->title }}</td>
			<td>{{ $plan->price_groups->title }}</td>
			<td>
				<a href="{{ route('plans.edit', ['id' => $plan->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('plans.destroy', ['id' => $plan->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>	
@stop