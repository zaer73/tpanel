@extends('layouts.essentials')

@section('page_title', trans('title_login'))

@section('body_class', 'gray-bg')

@section('body')
	<div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">
                	<img src="{{ asset('img/uploads/'.$logo) }}">
                </h1>
            </div>
            <p>
            	{{ $about_us }}
            </p>
            @if(session('status') == 'Password Changed')
				{{ trans('password_changed') }}
			@endif

            <form 
            	id="login-form" 
            	class="m-t" 
            	role="form" 
            	method="post" 
            	action="{{ route('users.login') }}" 
            >
            	{{ csrf_field() }}
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
                <div class="form-group">
                    <input type="text" ng-model="form.info.username" name="username" class="form-control" placeholder="{{ trans('username') }}" required="">
                </div>
                <div class="form-group">
                    <input type="password" ng-model="form.info.password" name="password" class="form-control" placeholder="{{ trans('password') }}" required="">
                </div>
                <button type="submit" 
                	class="btn btn-primary block full-width m-b" 
                >{{ trans('login') }}</button>

                <a href="{{ route('users.resetPassword') }}">
                	<small>{{ trans('forgotten_password') }}</small>
                </a>
                <a href="{{ route('users.secureLogin') }}">
                	{{ trans('secure_login') }}
                </a>
            </form>
        </div>
    </div>
@stop