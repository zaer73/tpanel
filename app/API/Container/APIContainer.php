<?php

class APIContainer {

	private $public_key = 'StKVny7kg2a73xXGUDmZCfDTJ';
	private $secret_key = 'XG54EaEnybgakdSzYQgE4vfj2PlcRE';
	public $data = [];
	private $base_url = 'http://tpanel.dev/api/';

	public function apiConnect($url)
	{

		$this->data = array_merge($this->data, [
			'public_key' => $this->public_key,
			'secret_key' => $this->secret_key
		]);

		$ch = curl_init();

	    curl_setopt($ch, CURLOPT_URL, $this->base_url.$url);

	    curl_setopt($ch, CURLOPT_HEADER, 0);

    	curl_setopt($ch, CURLOPT_POST, 1);

	    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);

		curl_exec($ch);

	    curl_close($ch);

	}

}

function Send_SMS($number, $recipient, $message, $port = 0, $flash = false)
{

	$api = new APIContainer;

	// $data = [
	// 	'id' => 338,
	// 	'text' => 'sallam khoobi ?!',
	// 	'from' => '50001276145267',
	// 	'to' => '09379010826',
	// 	'sendOn' => '',
	// 	'amount' => '400',
	// 	'sort' => '',
	// 	'sim' => '2',
	// 	'province' => '0',
	// 	'city' => '1',
	// 	'preNumber' => '91',
	// 	'gender' => '2',
	// 	'fromAge' => '1340',
	// 	'toAge' => '1350',
	// ];

	$api->data = [
		'from' => $number,
		'to' => $recipient,
		'text' => $message,
		'port' => $port,
		'flash' => $flash
	];

	$api->apiConnect('send-sms');

}

function apiCredit()
{

	$api = new APIContainer;
	$api->apiConnect('get-credit');

}

function apiReceive($id=0)
{

	$api = new APIContainer;
	$api->data = [
		'id' => $id
	];
	$api->apiConnect('receive');

}

function apiGroupSMS($data)
{
	$api = new APIContainer;
	$api->data = $data;
	$api->apiConnect('send-group-sms');
}

function apiGenderSend($data)
{

	$api = new APIContainer;
	$api->data = $data;
	$api->apiConnect('gender/send');

}

function apiGenderCount($data)
{

	$api = new APIContainer;
	$api->data = $data;
	$api->apiConnect('gender/count');

}

function apiGenderProvinces()
{

	$api = new APIContainer;
	$api->apiConnect('gender/provinces');

}

function apiGenderCities($province)
{

	$api = new APIContainer;
	$api->data = [
		'province' => $province
	];
	$api->apiConnect('gender/cities');

}