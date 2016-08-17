<?php

return [

	'gateways' => [
		// 'dargahpardakht' => [
		// 	'title' => 'dargahpardakht',
		// 	'container' => 'App\Containers\Payment\DargahPardakhtPaymentContainer',
		// 	'logo' => 'img/gateways/dargahpardakht.png',
		// 	'username' => '',
		// 	'password' => '',
		// 	'terminal_id' => ''
		// ],
		'mellat' => [
			'title' => 'mellat',
			'container' => 'App\Containers\Payment\MellatPaymentContainer',
			'logo' => 'img/gateways/mellat.png',
			'username' => 'khezr',
			'password' => 'khezr',
			'terminal_id' => '1207152'
		],
		// 'pasargad' => [
		// 	'title' => 'pasargad',
		// 	'container' => 'App\Containers\Payment\PasargadPaymentContainer',
		// 	'logo' => 'img/gateways/pasargad.jpg',
		// 	'merchant_code' => '111111',
		// 	'terminal_code' => '111111'
		// ],
		// 'paypaad' => [
		// 	'title' => 'paypaad',
		// 	'container' => 'App\Containers\Payment\PaypaadPaymentContainer',
		// 	'logo' => 'img/gateways/paypaad.png',
		// 	'merchant_code' => '111111',
		// 	'terminal_code' => '111111'
		// ]
	],
		
];