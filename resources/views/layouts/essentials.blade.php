<!DOCTYPE html>
<html lang="{{ site_language() }}" ng-app="inspinia">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ site_title() }} - @yield('page_title')</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/assets.css') }}">
	<link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	@yield('custom_css')
	{!! rtl_style() !!}
	<?php /*<script src="{{ asset('js/assets.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/tpanel-controllers.js') }}"></script>*/?>
	@yield('js')
</head>
<body class="@yield('body_class')">
	@yield('body')
</body>
</html>