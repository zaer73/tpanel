<head>
	<script src="{{ asset('js/jquery/jquery-2.1.1.min.js') }}"></script>
	<script>
		jQuery(document).ready(function(){
			jQuery('#moving-to-gateway-form').trigger('submit');
		})
	</script>
</head>
<body>
	<form method="post" id="moving-to-gateway-form" action="{{ $data['url'] }}">
		@foreach($data as $key => $value)
		<?php if($key == 'url') continue;?>
		<input type="hidden" name="{{ $key }}" value="{{ $value }}">
		@endforeach
	</form>
</body>