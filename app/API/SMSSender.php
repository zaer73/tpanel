<?php

namespace App\API;

use Illuminate\Http\Request;
use App\Line;
use App\User;
use App\Events\SMS;
use App\Services\GenderSMSService;

class SMSSender 
{

	private $exception, $creditControl, $line, $user;

	public function __construct(User $user, Request $request)
	{
		$this->user = $user;

		$this->request = $request;

		$this->exception = app(ExceptionHandler::class);

		$this->line = $this->getLine();

		$this->checkLine();
	}

	public function send($type)
	{

		$numbers = (new CreditController(
			$this->line, 
			$this->request,
			$this->user
		))->handle($type);

		foreach( $numbers as $number )
		{
			event(new SMS(
				0, 
				$number, 
				$this->request->text, 
				$this->line->id, 
				$this->user->id,
				/*$type=*/0, 
				/*$scheduled_on=*/'0000-00-00 00:00:00', 
				/*$queueName=*/'singleSMS', 
				/*$flash=*/false, 
				/*$brand=*/null, 
				/*$group_hash=*/null, 
				$this->user
			));
		}

		$this->exception->success;

	}

	public function gender()
	{

		$totalCost = (new CreditController(
			$this->line, 
			$this->request,
			$this->user
		))->handle('gender_from_api');

		$GenderSMSService = app(GenderSMSService::class);

		$this->request->merge([
			'line' => $this->line->id,
			'user_id' => $this->user->id
		]);

		$returnId = $GenderSMSService->sendBulk($this->request, $totalCost);

		die(json_encode([
			'returnId' => $returnId
		]));

	}

	private function getLine()
	{
		$line = Line::whereNumber($this->request->from)->first();

		if( !$line ) 
		{
			$this->exception->line_not_valid;
		}

		return $line;
	}

	private function checkLine()
	{
		if( $this->user->role == 2 )
		{
			return true;
		}

		if( $this->line->general )
		{
			if(
				$this->user->generalLines()
					->whereLineId($this->line->id)
					->first()
			)
			{
				return true;
			}
		}

		if( $this->user->role == 1 )
		{
			if(
				$this->line->user_id == 0 
				&& $this->line->agent_id == $this->user->id
			)
			{
				return true;
			}
		}

		if( $this->user->role == 0 )
		{
			if( $this->line->user_id == $this->user->id ) 
			{
				return true;
			}
		}

		$this->exception->no_right_to_use_line;

	}

}