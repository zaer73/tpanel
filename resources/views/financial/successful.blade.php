@extends('layouts.essentials')

@section('page_title', trans('successful_checkout'))

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
<meta http-equiv="refresh" content="3; URL='/" />
@stop

@section('body')
	<div id="page-wrapper" style="width:100%" class="gray-bg">
		<h2 style="margin:0">{{ trans('successful_checkout') }}</h2>
		<div class="alert alert-success">
			<p>
				{{ trans('successful_checkout_redirection') }}
			</p>
		</div>
		<div class="back">
			<a href="/" class="btn btn-primary">
				{{ trans('manual_redirection') }}
			</a>
		</div>
	</div>
@stop