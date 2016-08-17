@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('transfer-to-email.store') }}">
		{{ csrf_field() }}
		<select name="number">
		@foreach($lines as $line)
			<option value="{{ $line->number }}">{{ $line->number }}</option>
		@endforeach
		</select>
		<input type="text" name="email" placeholder="email"><br>
		<button type="submit">submit</button>
	</form>

	@if(count($errors))
	{{ dump($errors) }}
	@endif
@stop