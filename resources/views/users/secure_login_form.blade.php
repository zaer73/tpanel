@extends('layouts.essentials')

@section('page_title', trans('title_secure_login'))

@section('body_class', 'gray-bg')

@section('body')
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
    	<h2>{{ trans('title_secure_login') }}</h2>
		<form 
			method="post" 
			action="{{ route('users.secureLogin.form') }}"
			class="m-t"
			role="form"
        >
        	@if(count($errors))
        	<div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
            		<li>
            			{{ $error }}
            		</li>
                    @endforeach
        		</ul>
        	</div>
            @endif
			{{ csrf_field() }}
			<div class="form-group">
				<input type="text" name="username" ng-model="form.info.username" class="form-control" placeholder="{{ trans('username') }}" required="">
			</div>
			<div class="form-group">
				<input type="password" name="password" ng-model="form.info.password" class="form-control" placeholder="{{ trans('password') }}" required>
			</div>
			<button 
				type="submit"
				class="btn btn-primary block full-width m-b" 
			>{{ trans('login') }}</button>
		</form>

		<a href="{{ route('users.resetPassword') }}">{{ trans('forgotten_password') }}</a> 
		<a href="{{ route('users.secureLogin') }}">{{ trans('secure_login') }}</a>
	</div>
</div>
@stop