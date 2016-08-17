@extends('layouts.master')

@section('body')
<h2>{{ trans('title_report') }}</h2>
{{ trans('report_last_login_time') }}
{{ jalali(Auth::user()->last_login, '', true) }}
{{ trans('report_last_login_ip') }}
{{ Auth::user()->last_ip }}
@stop