<?php

namespace App\API;

use App\Helpers\SMS\creditControl;

use App\Services\GenderSMSService;

class CreditController {

	use creditControl;

	private $line, $request, $user, $exception;

	public function __construct($line, $request, $user)
	{

		$this->line = $line;
		$this->request = $request;
		$this->user = $user;

		$this->exception = app(ExceptionHandler::class);

	}

	public function handle($type)
	{
		$smart = false;
		$international = false;

		if(is_array($this->request->to))
		{

			$okayNumbers = $this->checkBlackList($this->request->to, $this->user);

		} else {

			$GenderSMSService = app(GenderSMSService::class);

			$okayNumbers = $GenderSMSService->getCount($this->request);

		}

		$totalCost = $this->message_pages($this->line, $this->request->text)*total_cost($okayNumbers, $this->request->text, $smart, $international, $this->user);

		if($this->user->credit < $totalCost)
		{
			$this->exception->not_enough_credit;
		}

		$this->saveSMSTransaction($type, $totalCost, $this->user);

		return $okayNumbers;

	}

}