@extends('layouts.essentials')

@section('js')
	<script>
		function submitForm(key)
		{
			var formName = 'paymentForm'+key;
			document[formName].submit()
		}
	</script>
@stop

@section('body')
	
	<div class="wrapper wrapper-content animated fadeInRight">
	    <div class="row">
	        <div class="col-md-12 col-sm-12 col-xs-12">
	            <div class="ibox">
	                <div class="ibox-content">
	                    <h2>{{ trans('PLEASE_SELECT_PAYMENT_GATEWAY') }}</h2>
	                    <div class="gateways">
	                    	@foreach($gateways as $key => $gateway)
		                        <form name="paymentForm{{ $key }}" action="/financial/checkout/moving-to-gateway" id="gateway-{{ $key }}">
		                            <input type="hidden" name="gateway" value="{{ $key }}">
		                            <a href="javascript: submitForm('{{ $key }}')">
			                            <img src="{{ asset($gateway['logo']) }}" 
			                            	style="float:right;width:15%;cursor: pointer;" 
			                            	alt="{{ $gateway['title'] }}" 
			                            	title="{{ $gateway['title'] }}" 
			                            	style="cursor: pointer" 
			                            >
		                        </form>
		                    @endforeach 
	                    </div>
	                    <div style="clear:both"></div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop
