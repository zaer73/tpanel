@extends('layouts.master')

@section('body')
	<form method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="file" name="file"><br>
		<button type="submit">upload</button>
	</form>

	{{ dump($errors) }}
@stop