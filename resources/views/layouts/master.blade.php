<!DOCTYPE html>
<html>
<head>
	<title>tpanel</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
	<style type="text/css">
		body{
			padding: 15px;
			direction: rtl;
			font-family: 'Tahoma';
			word-spacing: 10px;
		}
		.float_right{
			float: right;
		}
		.container{
			width: 1300px;
		}
		td{
			padding: 20px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-3 col-sm-3 col-xs-12 float_right">
			<ul>
				@include('includes.sidebar')
			</ul>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-12 float_right">
			@yield('body')
		</div>
	</div>
</body>
</html>