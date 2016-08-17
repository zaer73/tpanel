@extends('layouts.essentials')

@section('page_title', trans('unsuccessful_checkout'))

@section('custom_css')
<style>
	body{
		display: table;
    	width: 100%;
	}
	#page-wrapper{
	    width: 100%;
	    display: table-cell;
	    vertical-align: middle;
	    text-align: center;
	}
	.alert{
	    margin: 40px auto;
	    width: 30%;
	    text-align: center;
	}
</style>
@stop

@section('body')
	<div id="page-wrapper" style="width:100%" class="gray-bg">
		<h2 style="margin:0">{{ trans('unsuccessful_checkout') }}</h2>
		<div class="alert alert-danger">
			<p>
				{{ $error }}
			</p>
		</div>
		<div class="back">
			<a href="/" class="btn btn-primary">
				{{ trans('back_to_dashboard') }}
			</a>
		</div>
	</div>
@stop