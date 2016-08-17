<?php

namespace App\API;

class ExceptionHandler {

	private $exceptions = [
		'unknown' => [
			'errorId' => '-1',
			'errorMessage' => 'Unknown error',
		],
		'auth_req' => [
			'errorId' => '1' ,
			'errorMessage' => 'Authentication required'
		],
		'auth_fail' => [
			'errorId' => '2',
			'errorMessage' => 'Authentication failed'
		],
		'not_found' => [
			'errorId' => '3',
			'errorMessage' => 'Method not found'
		],
		'not_enough_args' => [
			'errorId' => '4',
			'errorMessage' => 'Not enough arguments'
		],
		'user_not_valid' => [
			'errorId' => '5',
			'errorMessage' => 'User is not valid'
		],
		'line_not_valid' => [
			'errorId' => '6',
			'errorMessage' => 'Line is not valid'
		],
		'no_right_to_use_line' => [
			'errorId' => '7',
			'errorMessage' => 'You have no right to use this line'
		],
		'not_enough_credit' => [
			'errorId' => '8',
			'errorMessage' => 'You have not enough credit to do this action'
		],
		'not_json_numbers' => [
			'errorId' => '9',
			'errorMessage' => 'Numbers must be a valid json encoded string'
		]
	];

	private function errorBody($errorSlug)
	{
		return json_encode([
			'error_code' => $this->exceptions[$errorSlug]['errorId'],
			'error_message' => $this->exceptions[$errorSlug]['errorMessage']
		]);
	}

	private function successBody()
	{
		return json_encode([
			'error_code' => 0,
			'message' => 'Sent successfully'
		]);
	}

	public function __get($errorSlug)
	{
		if( $errorSlug == 'success' )
		{
			die($this->successBody());
		}

		if( !isset($this->exceptions[$errorSlug]) )
		{
			return $this->errorBody('unknown');
		}
		die($this->errorBody($errorSlug));

	}

}