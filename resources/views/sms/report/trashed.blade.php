@extends('layouts.master')

@section('body')
	<table>
		<tr>
			<th>id</th>
			<th>sms_id</th>
			<th>restore</th>
			<th>destory</th>
			<th>type</th>
			<th>text</th>
		</tr>
	@foreach($messages as $msg)
		<tr>
			<td>{{ $msg->id }}</td>
			<td>{{ $msg->sms_id }}</td>
			<td>
				<form method="post" action="{{ route('sms.restore', ['id' => $msg->sms_id]) }}">
					{{ csrf_field() }}
					<button type="submit">restore</button>
				</form>
			</td>
			<td>
				<form method="post" action="{{ route('sms.destroy', ['id' => $msg->id]) }}">
					{{ csrf_field() }}
					<button type="submit">destroy</button>
				</form>
			</td>
			<td>{{ trashed_sms_type($msg->type) }}</td>
			<td>{{ str_limit($msg->text, 200) }}</td>
		</tr>
	@endforeach
	</table>
@stop

