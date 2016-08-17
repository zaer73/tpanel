@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>id</th>
			<th>type</th>
			<th>line</th>
			<th>start</th>
			<th>finish</th>
			<th>question</th>
			<th>answer</th>
			<th>reply</th>
			<th>status</th>
			<th>edit</th>
			<th>delete</th>
		</tr>
	@foreach($polls as $poll)
		<tr>
			<td>{{ $poll->id }}</td>
			<td>{{ $poll->type }}</td>
			<td>{{ $poll->line }}</td>
			<td>{{ jalali($poll->started_at) }}</td>
			<td>{{ jalali($poll->finished_at) }}</td>
			<td>{{ str_limit($poll->question, 200) }}</td>
			<td>{{ str_limit($poll->answer, 200) }}</td>
			<td>{{ str_limit($poll->reply, 200) }}</td>
			<td>{{ $poll->status }}</td>
			<td><a href="{{ route('polls.edit', ['id' => $poll->id]) }}">edit</a></td>
			<td>
				<form method="post" action="{{ route('polls.destroy', ['id' => $poll->id]) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">delete</button>
				</form>
			</td>
		</tr>
	@endforeach
	</table>
@stop