@extends('layouts.essentials')

@section('page_title', trans('title_reset_password'))

@section('body_class', 'gray-bg')

@section('body')
	<div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
        	<h2>{{ trans('title_reset_password') }}</h2>
			<h3>بازیابی با ایمیل</h3>
			<form 
				method="post" 
				class="m-t" 
            	role="form"
				action="{{ route('users.resetPassword') }}"
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
					<input type="text" name="email" ng-model="form.info.email" class="form-control" placeholder="{{ trans('email') }}" required="">
				</div>
				<button type="submit"
					class="btn btn-primary block full-width m-b" 
                	ng-class="{processing:ajaxInProcess}"
                	ng-disabled="ajaxInProcess"
				>{{ trans('reset_password') }}</button>
			</form>
            
			<h3>بازیابی با پیامک</h3>
			<form 
				method="post" 
				action="{{ route('users.resetPassword.mobile') }}"
				class="m-t" 
            	role="form"
			>
				{{ csrf_field() }}
				<div class="form-group">
					<input type="text" name="username" ng-model="form.info.username" placeholder="{{ trans('username') }}" class="form-control" required="">
				</div>
				<div class="form-group">
					<input type="text" name="mobile" ng-model="form.info.mobile" placeholder="{{ trans('mobile') }}" class="form-control" required="">
				</div>
				<button type="submit"
					class="btn btn-primary block full-width m-b" 
                	ng-class="{processing:ajaxInProcess}"
                	ng-disabled="ajaxInProcess"
                >{{ trans('reset_password') }}</button>
			</form>
		</div>
	</div>
@stop