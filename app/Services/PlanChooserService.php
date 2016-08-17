<?php
namespace App\Services;
use Auth;

class PlanChooserService {

	private $plan, $user;

	public function set($plan_id, $user_id){

		$this->plan = \App\Plan::whereId($plan_id)->first();
		$this->user = \App\User::whereId($user_id)->first();

		if(!$this->plan) abort(403);

		// set lines to user
		$this->setLines();

		// set fluent credit
		$this->user->update([
			'fluent_group_id' => $this->plan->fluent_credit_group
		]);

		// set permissions
		$this->setPermissions();

		// set init credit
		if($this->plan->init_credit){
			$this->user->update([
				'credit' => $this->plan->init_credit
			]);
		}

		// create plan record
		$this->createPlanRecord();
	}

	private function setLines(){
		$line_ids = $this->plan->line_id;
		if(empty($line_ids) || !count($line_ids)) return;
		$line_ids = $line_ids->lists('id')->toArray();
		$line_ids = array_unique($line_ids);
		$line_ids = array_filter($line_ids);
		foreach($line_ids as $line_id){
			$this->user->generalLines()->create([
				'line_id' => $line_id,
				'expires_at' => $this->plan->expires_at
			]);
		}
	}

	private function setPermissions(){
		$permission_group = \App\PermissionGroup::whereId($this->plan->permission_group)->first()->toArray();
		unset($permission_group['user_id']);
		$permissions = \App\Permission::firstOrCreate(['user_id' => $this->user->id]);
		$permissions->update($permission_group);
	}

	private function createPlanRecord(){
		$this->user->plan()->firstOrcreate([
			'plan_id' => $this->plan->id,
			'expires_at' => $this->plan->expires_at
		]);
	}

}