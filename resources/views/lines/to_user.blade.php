@extends('layouts.master')

@section('body')
	<h2>{{ trans('lines_line_to_username', ['username' => $user->username]) }}</h2>
	<label>{{ trans('lines_line_number') }}</label>
	<form method="post">
		{{ csrf_field() }}
		<select name="line">
			@foreach($lines as $line)
			<option value="{{ $line->id }}">
				{{ $line->number }}
			</option>
			@endforeach
		</select>
		<button type="submit">{{ trans('lines_to_user_submit') }}</button>
	</form>
@stop