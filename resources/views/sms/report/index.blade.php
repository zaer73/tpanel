@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>id</th>
			<th>content</th>
			<th>date</th>
			<th>status</th>
			<th>resend</th>
			<th>delete</th>
			<th>type</th>
			<th>number</th>
		</tr>
	@foreach ($messages as $msg)
		<tr>
			<td>{{ $msg->id }}</td>
			<td>{{ str_limit($msg->text,20) }}</td>
			<td>{{ jalali($msg->create_at) }}</td>
			<td>{{ sms_status($msg) }}</td>
			<td>
				<form method="post" action="{{ route('sms.resend', ['id' => $msg->id]) }}">
					{{ csrf_field() }}
					<button type="submit">resend</button>
				</form>
			</td>
			<td>
				<form method="post" action="{{ route('sms.delete.sent', ['id' => $msg->id]) }}">
					{{ csrf_field() }}
					<button type="submit">delete</button>
				</form>
			</td>
			<td>{{ sms_type($msg->type) }}</td>
			<td>{{ $msg->reciever }}</td>
		</tr>
	@endforeach
	</table>
@stop