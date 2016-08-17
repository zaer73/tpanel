@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('charges.update', ['id' => $charge->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="code" placeholder="code" value="{{ $charge->code }}" disabled="disabled"><br>
		<input type="text" name="credit" placeholder="credit" value="{{ $charge->credit }}"><br>
		<input type="date" name="expires_at" value="{{ date('Y-m-d', strtotime($charge->expires_at)) }}"><Br>
		<button type="submit">submit</button>
	</form>

	{{ dump($errors) }}
@stop