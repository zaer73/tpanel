@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>code</th>
			<th>user credit</th>
			<th>client credit</th>
			<th>user</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
		@foreach($codes as $code)
		<tr>
			<td>{{ $code->code }}</td>
			<td>{{ $code->user_credit }}</td>
			<td>{{ $code->client_credit }}</td>
			<td>{{ $code->user->username }}</td>
			<td>
				<a href="{{ route('marketing-codes.edit', ['id' => $code->id]) }}">edit</a>
			</td>
			<td>
				<form method="post" action="{{ route('marketing-codes.destroy', ['id' => $code->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
@stop