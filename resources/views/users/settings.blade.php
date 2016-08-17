@extends('layouts.master')

@section('body')
<h2>{{ trans('title_settings') }}</h2>

<form method="post" action="{{ route('users.setting.update', ['id' => Auth::id()]) }}">
	{{ csrf_field() }}
	{{ method_field('PUT') }}
	<label>{{ trans('sms_on_login') }}</label>
	<input type="checkbox" name="sms_on_login" value="1" {{ checkbox($settings->sms_on_login) }}><br>
	<label>{{ trans('sms_on_ticket') }}</label>
	<input type="checkbox" name="sms_on_ticket" value="1" {{ checkbox($settings->sms_on_ticket) }}><br>
	<label>{{ trans('sms_balance') }}</label>
	<input type="checkbox" name="sms_balance" value="1" {{ checkbox($settings->sms_balance) }}><br>
	<button type="submit">{{ trans('settings_save') }}</button>
</form>
@stop