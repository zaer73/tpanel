@extends('layouts.essentials')

@section('page_title', trans('title_plans'))

@section('body_class', 'gray-bg')

@section('body')
	<div class="middle-box text-center animated fadeInDown" style="max-width:1000px">
        <div>
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
                action="{{ route('users.choosePlan', ['domain' => $domain]) }}" 
            >
            	{{ csrf_field() }}
                <div class="row">
                    @foreach($plans as $plan)  
                	<div class="col-lg-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>{{ $plan->title }}</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm-12 b-r">
                                        <p>{{ $plan->description }}</p>
                                    </div>
                                    <div class="col-sm-12"><h4>{{ trans('available_modules') }}</h4>
                                        @foreach($plan->permission_groups->toArray() as $permission_key => $permission_value)
                                            @if(in_array($permission_key, $defined_permissions) && $permission_value == 1)
                                            <div class="col-sm-12">
                                                <b>{{ trans('permission_'.$permission_key) }}</b>
                                                <i class="fa fa-check"></i>

                                                <div class="hr-line-dashed"></div>
                                            </div>

                                            @endif
                                        @endforeach
                                    </div>
                                    @foreach($plan->line as $line)
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <h4>{{ trans('lines_line_number') }}</h4>
                                            <b>{{ $line->number }}</b>
                                        </div>
                                    @endforeach
                                    <!-- <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h4>{{ trans('plan_value') }}</h4>
                                        <b>{{ number_format($plan->value).trans('rials') }}</b>
                                    </div> -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <button name="plan_id" value="{{ $plan->id }}" type="submit" class="btn btn-primary">{{ trans('buy') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
@stop