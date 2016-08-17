@extends('layouts.essentials')

@section('page_title', trans('title_signup'))

@section('js')
<script src="{{ asset('js/angular/angular.min.js') }}"></script>
<script>
    var myApp = angular.module('inspinia',[]);

    myApp.controller('SignupController', ['$scope', function($scope) {
        $scope.type = 0;
    }]);
</script>
@stop

@section('body_class', 'gray-bg')

@section('body')
	<div class="middle-box text-center loginscreen animated fadeInDown" ng-controller="SignupController">
        <div>
            <img src="{{ asset('img/uploads/'.setting('logo')) }}">
            <h2>{{ trans('signup') }} {{ ($plan->type == 0) ? trans('user') : trans('agent') }}</h2>
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
            <form method="post"
                class="form-horizontal"
                action="{{ route('users.signup', ['domain' => $domain]) }}" 
            >
            	{{ csrf_field() }}
            	<input type="hidden" name="type" value="@{{ type }}">
                <div ng-include="'views/includes/form_response.html'"></div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="h-first-name">
                            {{ trans('user_type')}}
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" ng-model="type">
                                <option value="0">{{ trans('HAGHIGHI') }}</option>
                                <option value="1">{{ trans('HOGHOOGHI') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div ng-if="type == 0">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-4 control-label" for="h-first-name">
                                {{ trans('first_name')}}
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" maxlength="25" name="first_name" placeholder="{{ trans('first_name')}}" class="form-control" id="h-first-name" required>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
                <div ng-if="type == 0">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-4 control-label" for="h-last-name">
                                {{ trans('last_name')}}
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" maxlength="25" name="last_name" placeholder="{{ trans('last_name')}}" class="form-control" id="h-last-name" required>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
                <div ng-if="type == 1">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-4 control-label" for="h-last-name">
                                {{ trans('name')}}
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" maxlength="25" name="name" placeholder="{{ trans('name')}}" class="form-control" id="h-last-name" required>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
                <div ng-if="type == 1">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="o-submit-code">
                            {{ trans('SUBMIT_CODE') }}
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" name="submit_code" placeholder="{{ trans('SUBMIT_CODE') }}" class="form-control" id="o-submit-code" required>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
                <div ng-if="type == 1">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-4 control-label" for="o-link_first_name">
                                {{ trans('LINK_FIRST_NAME') }}
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" name="link_first_name" placeholder="{{ trans('LINK_FIRST_NAME') }}" class="form-control" id="o-link_first_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
                <div ng-if="type == 1">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-4 control-label" for="o-link_last_name">
                                {{ trans('LINK_LAST_NAME') }}
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="text" name="link_last_name" placeholder="{{ trans('LINK_LAST_NAME') }}" class="form-control" id="o-link_last_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="h-username">
                            {{ trans('username')}}
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input maxlength="25" type="text" name="username" placeholder="{{ trans('username')}}" class="form-control" id="h-username" required>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="h-email">
                            {{ trans('email')}}
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input maxlength="50" type="text" name="email" placeholder="{{ trans('email')}}" class="form-control" id="h-email" required>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="h-mobile">
                            {{ trans('mobile')}}
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" maxlength="11" name="mobile" placeholder="{{ trans('mobile')}}" class="form-control" id="h-mobile" required>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="h-national_code">
                            {{ trans('national_code')}}
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" maxlength="10" name="national_code" placeholder="{{ trans('national_code')}}" class="form-control" id="h-national_code" required>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="h-password">
                            {{ trans('password')}}
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" maxlength="30" name="password" placeholder="{{ trans('password')}}" class="form-control" id="h-password" required>
                        </div>
                    </div>
                </div>
                <a href="/users/change-plan/{{ $domain }}" class="btn btn-warning">{{ trans('change_plan') }}</a>
                <button type="submit" class="btn btn-primary">{{ trans('SUBMIT')}}</button>
            </form>
        </div>
    </div>
@stop