@extends('layouts.dashboard')

@section('content')
@if(session('status'))
	<h3>{{ session('status') }}</h3>
@endif
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">	
				<div class="ibox-title">
					<h2>{{ trans('change_password') }}</h2>
				</div>
				<div class="ibox-content">
					<form 
						method="post" 
						action="{{ route('users.profile.update', ['id' => Auth::id(), 'type' => 'password']) }}"
						id="update_profile_password" 
						class="form-horizontal"
						role="form"
						ng-submit="form.submit($event)"
				    	ng-controller="ajaxFormController as form"
				    	ng-init="formErrors={{ json_encode($errors->all()) }}"
				    >
				    	<div class="alert alert-danger" ng-show="formErrors.length">
				            <ul>
				        		<li ng-repeat="error in formErrors">
				        			@{{ error }}
				        		</li>
				    		</ul>
				    	</div>
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label class="col-sm-2 control-label" for="old-password">
								{{ trans('old_password') }}
							</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="password" name="old_password" ng-model="form.info.old_password" placeholder="{{ trans('old_password') }}" class="form-control" id="old-password">	
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="new-password">
								{{ trans('new_password') }}
							</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="password" name="new_password" ng-model="form.info.new_password" placeholder="{{ trans('new_password') }}" class="form-control" id="new-password">	
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="repeat-new-password">
								{{ trans('repeat_new_password') }}
							</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="password" name="repeat_new_password" ng-model="form.info.repeat_new_password" placeholder="{{ trans('repeat_new_password') }}" class="form-control" id="repeat-new-password">
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								<button class="btn btn-primary" type="submit">{{ trans('change_password') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">	
				<div class="ibox-title">
					<h2>{{ trans('birthday') }}</h2>
				</div>
				<div class="ibox-content">
					<form 
						method="post" 
						action="{{ route('users.profile.update', ['id' => Auth::id(), 'type' => 'birth']) }}"
						class="form-horizontal"
						id="update_profile_birth" 
						role="form"
						novalidate="novalidate"
						ng-submit="form.submit($event)"
				    	ng-controller="ajaxFormController as form"
				    	ng-init="formErrors={{ json_encode($errors->all()) }}"
				    >
				    	<div class="alert alert-danger" ng-show="formErrors.length">
				            <ul>
				        		<li ng-repeat="error in formErrors">
				        			@{{ error }}
				        		</li>
				    		</ul>
				    	</div>
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="form-group">
							<label class="col-sm-2 control-label" for="birth_day">
								{{ trans('birth_day') }}
							</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="text" name="birth_day" ng-model="form.info.birth_day" placeholder="{{ trans('birth_day') }}" class="form-control" id="birth_day" value="{{ jalali(Auth::user()->date_of_birth, 'j') }}">	
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="birth_month">
								{{ trans('birth_month') }}
							</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="text" name="birth_month" ng-model="form.info.birth_month" placeholder="{{ trans('birth_month') }}" class="form-control" id="birth_month" value="{{ jalali(Auth::user()->date_of_birth, 'm') }}">	
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="birth_year">
								{{ trans('birth_year') }}
							</label>
							<div class="col-md-10 col-sm-10 col-xs-12">
								<input type="text" name="birth_year" ng-model="form.info.birth_year" placeholder="{{ trans('birth_year') }}" class="form-control" id="birth_year" value="{{ jalali(Auth::user()->date_of_birth, 'Y') }}">
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								<button class="btn btn-primary" type="submit">{{ trans('change_password') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop