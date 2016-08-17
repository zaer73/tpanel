<?php

namespace App\Validation;

class NationalCodeValidation {

	private $nationalCode;

	public function __construct($nationalCode)
	{
		$this->nationalCode = $nationalCode;
	}

	public function validate()
	{
		if(strlen($this->nationalCode) != 10 ) return false;

		$arrayOfDigits = array_reverse(
			array_map('intval', str_split($this->nationalCode))
		);
		$controlDigit = $arrayOfDigits[0];
		unset($arrayOfDigits[0]);
		$timeTotal = 0;
		foreach($arrayOfDigits as $key => $value)
		{
			$timeTotal += ($key+1)*$value;
		}

		$timeTotalAfterDivision = $timeTotal%11;

		if($timeTotalAfterDivision < 2)
		{
			if($timeTotalAfterDivision == $controlDigit)
			{
				return true;
			}
		}

		if(11 - $timeTotalAfterDivision == $controlDigit)
		{
			return true;
		}

		return false;

	}

}