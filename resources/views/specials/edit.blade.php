@extends('layouts.master')

@section('body')
	<form method="post" action="{{ route('specials.update', ['id' => $special->id]) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<input type="text" name="title" placeholder="title" value="{{ $special->title }}"><br>
		<input type="text" name="description" placeholder="description" value="{{ $special->description }}"><br>
		<input type="text" name="texts" placeholder="texts" value="{{ $special->texts }}"><br>
		<input type="text" name="value" placeholder="value" value="{{ $special->value }}"><br>
		<button type="submit">submit</button>
	</form>
@stop