@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>id</th>
			<th>text</th>
			<th>date</th>
			<th>delete</th>
			<th>reply</th>
			<th>forward</th>
			<th>from</th>
			<th>to</th>
		</tr>
	@foreach($messages as $msg)
		<tr>
			<td>{{ $msg->id }}</td>
			<td>{{ str_limit($msg->text, 20) }}</td>
			<td>{{ jalali($msg->created_at) }}</td>
			<td>delete</td>
			<td>reply</td>
			<td>forward</td>
			<td>{{ $msg->from }}</td>
			<td>{{ $msg->to }}</td>
		</tr>
	@endforeach
	</table>
@stop