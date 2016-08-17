<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\API\ExceptionHandler;
use App\Http\Requests;
use App\User;
use App\APIKey;
use App\API\SMSSender;
use App\Services\GenderSMSService;

class IncomingAPIController extends Controller
{

	private $sender, $user, $exception, $request;

    public function __construct(ExceptionHandler $exception, Request $request)
    {
        $this->exception = $exception;
        $this->request = $request;
    	$this->user = $this->getUser();
    }

    public function getUser(){
		$userId = APIKey::wherePublicKey($this->request->public_key)->whereSecretKey($this->request->secret_key)->first()->user_id;

		$user = User::whereId($userId)->first();

		if( !$user ) $this->exception->user_not_valid;

		return $user;
	}
    
	public function postSendSMS()
	{	
		if(	
			!$this->validateSend()
		){
			$this->exception->not_enough_args;
		}

		$this->request->merge([
			'to' => [$this->request->to]
		]);

		(new SMSSender($this->user, $this->request))->send('single_from_api');
	}

	public function postSendGroupSMS()
	{
		if(	
			!$this->validateSend()
		){
			$this->exception->not_enough_args;
		}

		if( !json_decode($this->request->to) )
		{
			$this->exception->not_json_numbers;
		}

		$this->request->merge([
			'to' => json_decode($this->request->to)
		]);

		(new SMSSender($this->user, $this->request))->send('group_from_api');
	}	

	private function validateSend()
	{
		if(	
			!$this->request->has('text') 
			|| !$this->request->has('from') 
			|| !$this->request->has('to') 
		)
		{
			return false;
		}

		return true;
	}

	public function getCredit()
	{
		die(json_encode([
			"your_credit" => $this->user->credit
		]));
	}

	public function receive()
	{

		$received = $this->user->received();

		if( $this->request->has('id') )
		{
			$received = $received->where('id', '>', $this->request->id);
		}

		$received = $received->limit(100)->get();

		die($received->toJson());

	}

	public function postSendGenderSMS()
	{

		$this->validateGender();

		(new SMSSender($this->user, $this->request))->gender();

	}

	private function validateGender()
	{
		if(
			!$this->request->has('text') 
			|| !$this->request->has('from') 
			// || !$this->request->has('sendOxn')
			|| !$this->request->has('amount')
			// || !$this->request->has('sort')
			|| !$this->request->has('sim')
			|| !$this->request->has('province')
			|| !$this->request->has('city')
			|| !$this->request->has('preNumber')
			|| !$this->request->has('gender')
			|| !$this->request->has('fromAge')
			|| !$this->request->has('toAge')
		)
		{
			$this->exception->not_enough_args;
		}

	}

	public function genderCount()
	{
		$GenderSMSService = app(GenderSMSService::class);

		$count = $GenderSMSService->getCount($this->request);

		die(json_encode([
			'count' => $count
		]));
	}

	public function genderProvince()
	{
		$GenderSMSService = app(GenderSMSService::class);

		$provinces = $GenderSMSService->getProvinces();

		die(json_encode($provinces));
	}

	public function genderCities()
	{
		$GenderSMSService = app(GenderSMSService::class);

		$cities = $GenderSMSService->getCities($this->request->province);

		die(json_encode($cities));
	}

	public function notFound()
	{
		$this->exception->not_found;
	}

}
