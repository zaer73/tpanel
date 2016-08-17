<?php
namespace App\Services;
use App\Filtering;

class SMSTextFilter {

	public function __construct(){
		$this->filters = Filtering::lists('filtering_key');
	}

	public function check($text){
		foreach($this->filters as $filter){
			if(preg_match("/{$filter}/", $text)){
				die(json_encode([
					'result' => 'exception',
					'errors' => trans('message_contains_filtered_words')
				]));
			}
		}
	}

}