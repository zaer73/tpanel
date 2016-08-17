@extends('layouts.master')

@section('body')
<h2>{{ trans('title_users') }}</h2>
<form method="post" action="{{ route('sms.send.group') }}">
	{{ csrf_field() }}
	<table>
		<tr>
			<th></th>
			<th>{{ trans('user_list_title') }}</th>
			<th>{{ trans('user_list_username') }}</th>
			<th>{{ trans('user_list_name') }}</th>
			<th>{{ trans('user_list_mobile') }}</th>
			<th>{{ trans('user_list_plan_expiration') }}</th>
			<th>{{ trans('user_list_plan_charge') }}</th>
			<th>{{ trans('user_list_parent_name') }}</th>
			<th>{{ trans('user_list_online_status') }}</th>
			<th>{{ trans('user_list_send_sms') }}</th>
		</tr>
		@foreach($users as $user)
		<tr>
			<td>
				@can('activateUser', $user)
				{!! activateUserLink($user) !!}
				@endcan

				@can('changeUserRole', $user)
				{!! changeUsersRoleLink($user) !!}
				@endcan

				@can('changeUserParent', $user)
				<a href="#">{{ trans('user_list_change_parent') }}</a>
				@endcan

				@can('deleteUser', $user)
				<a href="#">{{ trans('user_list_delete') }}</a>
				@endcan

				@can('editSetting', $user)
				<a href="#">{{ trans('user_list_edit_setting') }}</a>
				@endcan

				@can('lineToUser', $user)
				<a href="{{ route('lines.toUser', ['user' => $user->id]) }}">{{ trans('lines_line_to_user') }}</a>
				@endcan

				@can('loginForUser', $user)
				<a href="{{ route('users.loginBy', ['user' => $user->id]) }}">{{ trans('user_loginForUser') }}</a>
				@endcan
			</td>

			<td>
				{{ $user->id }}
			</td>

			<td>
				{{ $user->username }}
			</td>

			<td>
				{{ $user->name }}
			</td>

			<td>
				{{ $user->mobile }}
			</td>

			<td>
				
			</td>

			<td></td>

			<td>
				@if($user->parentUser)
				{{ $user->parentUser->name }}
				@endif
			</td>

			<td>{{ online_status($user) }}</td>

			<td><input type="checkbox" name="sendSMS[{{ $user->id }}]" value="1"></td>
		</tr>
		@endforeach
	</table>
	<button type="submit">{{ trans('user_list_send_group_sms_submit') }}</button>
</form>
@stop