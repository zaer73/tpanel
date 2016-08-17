<?php

namespace App\Services;

use App\Plan;
use App\User;
use App\Events\Financial\Transaction;

class AddPlanToInvoice {

	protected $plan, $user;

	public function __construct(Plan $plan, User $user)
	{

		$this->plan = $plan;
		$this->user = $user;

	}

	public function handle()
	{

		$this->addPlan();

	}

	public function addPlan()
	{
		event(new Transaction(
			$this->plan->value, 
			'minus', 
			$this->user, 
			'plan', 
			$this->plan->id, 
			trans('transaction_buy_plan', [
				'plan' => $this->plan->title
			]))
		);

	}

}