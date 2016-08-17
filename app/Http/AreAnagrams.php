<?php 

class AreAnagrams{

	public static function areStringsAnagrams($firstWord, $secondWord){

		if(strcmp(strrev($firstWord), $secondWord)) return true;
		return false;

	}

}

var_dump(AreAnagrams::areStringsAnagrams);