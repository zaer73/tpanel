@extends('layouts.master')

@section('body')
	<form method="post">
		{{ csrf_field() }}
		<input type="text" name="number" placeholder="number"><br>
		<select name="job_id">
			@foreach($occupations as $job)
			<option value="{{ $job->id }}">
				{{ $job->title }}
			</option>
			@endforeach
		</select>
		<button type="submit">submit</button>
	</form>

	{{ dump($errors) }}
@stop	