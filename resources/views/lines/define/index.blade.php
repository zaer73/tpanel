@extends('layouts.master')

@section('body')
	<form method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="text" name="province_id" placeholder="province"><br>
		<input type="text" name="city_id" placeholder="city"><br>
		<select select="job_id">
			@foreach($occupations as $occ)
			<option value="{{ $occ->id }}">
				{{ $occ->title }}
			</option>
			@endforeach
		</select><br>
		<select>
			<option value="0">male</option>
			<option value="1">female</option>
		</select><br>
		<input type="text" name="postal_code_id" placeholder="postal code"><br>
		<input type="text" name="number" placeholder="number"><br>
		<input type="file" name="file"><br>
		<button type="submit">submit</button>
	</form>

	{{ dump($errors) }}
@stop