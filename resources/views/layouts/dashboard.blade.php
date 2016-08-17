@extends('layouts.essentials')

@section('body')
	<div id="wrapper">

		@include('includes.sidebar')
		<div id="page-wrapper" class="gray-bg">
			@yield('content')
		</div>
	</div>
@stop