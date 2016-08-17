@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('transfer-to-email.update', ['id' => $transfer->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<select name="number">
		@foreach($lines as $line)
			<option value="{{ $line->number }}" {{ selected($transfer->number == $line->number) }}>{{ $line->number }}</option>
		@endforeach
		</select>
		<input type="text" name="email" placeholder="email" value="{{ $transfer->email }}"><br>
		<button type="submit">submit</button>
	</form>

	@if(count($errors))
	{{ dump($errors) }}
	@endif
@stop