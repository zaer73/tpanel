@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('customization.update', ['id' => $id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="contact_us" placeholder="contact us">

		<button type="submit">submit</button>
	</form>
@stop