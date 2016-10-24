<!DOCTYPE html>
<html ng-app="inspinia">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" value="{{ csrf_token() }}">

    <!-- Page title set in pageTitle directive -->
    <title page-title>{{ site_title() }}</title>

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/angular-notify/angular-notify.min.css') }}" rel="stylesheet">

    <!-- Font awesome -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Main Inspinia CSS files -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/plugins/persian-datepicker-0.4.5.css') }}">
    <link id="loadBefore" href="{{ asset('css/style.css') }}" rel="stylesheet">
    @if(setting('site_lang') == 'fa')
        <link id="rtlLanguageStyle" href="{{ asset('css/rtl.css') }}" rel="stylesheet">
    @endif


</head>

<!-- ControllerAs syntax -->
<!-- Main controller with serveral data used in Inspinia theme on diferent view -->
<body ng-controller="MainCtrl as main" class="@{{$state.current.data.specialClass}}" landing-scrollspy id="page-top">

<!-- Main view  -->
<div ui-view></div>

<!-- jQuery and Bootstrap -->
<script src="{{ asset('js/jquery/jquery-2.1.1.min.js') }}"></script>
<script src="{{ asset('js/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>

<!-- MetsiMenu -->
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>

<!-- SlimScroll -->
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Peace JS -->
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>

<!-- Main Angular scripts-->
<script src="{{ asset('js/angular/angular.min.js') }}"></script>
<script src="{{ asset('js/angular/angular-sanitize.js') }}"></script>
<script src="{{ asset('js/plugins/oclazyload/dist/ocLazyLoad.min.js') }}"></script>
<script src="{{ asset('js/angular-translate/angular-translate.min.js') }}"></script>
<!-- notify -->
<script src="{{ asset('js/plugins/angular-notify/angular-notify.min.js') }}"></script>
<script src="{{ asset('js/ui-router/angular-ui-router.min.js') }}"></script>
<script src="{{ asset('js/bootstrap/ui-bootstrap-tpls-0.12.0.min.js') }}"></script>
<script src="{{ asset('js/plugins/angular-idle/angular-idle.js') }}"></script>
<script src="{{ asset('js/datepicker/persian-date.js') }}"></script>
<script src="{{ asset('js/angular/persian-datepicker-0.4.5.min.js') }}"></script>

<!--
 You need to include this script on any page that has a Google Map.
 When using Google Maps on your own site you MUST signup for your own API key at:
 https://developers.google.com/maps/documentation/javascript/tutorial#api_key
 After your sign up replace the key in the URL below..
-->

<!-- Anglar App Script -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/translations.js') }}"></script>
<script src="{{ asset('js/directives.js') }}"></script>
<script src="{{ asset('js/tpanel-directives.js') }}"></script>
<script src="{{ asset('js/tpanel-services.js') }}"></script>
<script src="{{ asset('js/factories.js') }}"></script>
<script src="{{ asset('js/controllers.js') }}"></script>
<script src="{{ asset('js/tpanel-controllers.js') }}"></script>


<!-- <script src="{{ asset('js/min/app.min.js') }}"></script>
<script src="{{ asset('js/translations.js') }}"></script> -->

<script>
    var previousText = '{{ trans('previous') }}';
    var nextText = '{{ trans('next') }}';
    var lastText = '{{ trans('last') }}';
    var firstText = '{{ trans('first') }}';
    var showingText = '{{ trans('showing') }}';
    var entriesText = '{{ trans('entries') }}';
    var toText = '{{ trans('table_to') }}';
    var fromText = '{{ trans('table_from') }}';
    var noDataAvailableText = '{{ trans('no_data_available') }}';
    var searchText = '{{ trans('SEARCH') }}';
    var printText = '{{ trans('print') }}';
</script>

</body>
</html>
