<?php
namespace App\Containers\Payment\Paypaad;
/**
 * @version		pasargad.php 1.0 2010-10-26
 * @package		Pasargad
 */

/**
 * Pasargad Class
 * This class will help you create xml, sign it and communicate with Pasargad terminal.
 */
class Pasargad {

	var $response = NULL;

	/**
	 * Constructor
	 *
	 * This function just adds parameters which are predefined in the class.
	 * @param	array	Array of needed parameters
	 */
	function __construct($data=array()){
		//
	}

	/**
	 * Constructor
	 * for PHP 4
	 * This function just adds parameters which are predefined in the class.
	 * @param	array	Array of needed parameters
	 */
	function Pasargad($data=array()){
		$this->__construct($data);
	}

	/**
	 * This function creates the needed xml for pasargad terminal.
	 * 
	 * @param	object	PasargadCart object
	 * @return	string	XML for pasargad terminal
	 */
	function createXML($cart){
		$output = '<?xml version="1.0" encoding="utf-8" ?>'
		.'<invoice'
		.' time_stamp="'.$cart->time_stamp.'"'
		.' invoice_date="'.$cart->invoice_date.'"'
		.' invoice_number="'.$cart->invoice_number.'"'
		.' terminal_code="'.$cart->terminal_code.'"'
		.' merchant_code="'.$cart->merchant_code.'"'
		.' redirect_address="'.$cart->redirect_address.'"'
		.' referer_address="'.$cart->referrer_address.'"'
		.' delivery_days="'.(int)$cart->delivery_days.'"'
		.' total_amount="'.(int)$cart->total_amount.'"'
		.' buyer_name="'.$cart->buyer_name.'"'
		.' buyer_tel="'.$cart->buyer_tel.'"'
		.' delivery_address="'.$cart->delivery_address.'"'
		.'>'
		;

		$i=1; // First number
		if(count($cart->cart)>0){
			foreach($cart->cart as $item){
				// Generate xml
				$output .= '<item number="'.$i.'">'
				.'<content>'.$item['content'].'</content>'
				.'<fee>'.(int)$item['fee'].'</fee>'
				.'<count>'.(int)$item['count'].'</count>'
				.'<amount>'.(int)$item['amount'].'</amount>'
				.'<description>'.$item['description'].'</description>'
				.'</item>'
				;
				$i++; // Increase number
			}
		}

		$output .= '</invoice>';

		return $output;
	}

	/**
	 * This function generates the signature to use for Pasargad terminal
	 * 
	 * @param	string	XML Generated for Pasargad terminal
	 * @return	string	Signature for Pasargad terminal
	 */
	function sign($xml){
		touch('key.pem');
		$key = file_get_contents('key.pem');
		$priv_key = openssl_pkey_get_private($key); // notice: there must be pkcs#8 representation of your privateKey in .PEM file format.
		$signature = '';
		if(!openssl_sign($xml, $signature, $priv_key, OPENSSL_ALGO_SHA1)) {
			return false;
		}else{
			$result = base64_encode($signature);
		}
		return $result;
	}

	/**
	 * This function communicates and gets the data that we need to check our transaction
	 * 
	 * @param	string	tref that bank has returned
	 * @param	object	(optional) A PasargadCart object. It will be used if tref is empty.
	 * @return	object	An object of returned values by Pasargad
	 */
	function getResponse($tref='',$cart=NULL){
		$url = "https://paypaad.bankpasargad.com/PaymentTrace";
		$curl_session = curl_init($url); // Initiate CURL session -> notice: CURL should be enabled.
		curl_setopt($curl_session, CURLOPT_POST, 1);	// Set post method on.
		if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
		curl_setopt($curl_session, CURLOPT_FOLLOWLOCATION, 1); // Follow where ever it goes
		}
		curl_setopt($curl_session, CURLOPT_HEADER, 0); //Don't return http headers
		curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, 1); // Return the content of the call

		// Make post parameters
		if($tref!='' && $tref!=NULL && !empty ($tref)){ // If there is any tref
			// This parameter is enough
			$post_data = "tref=".$tref;
		}elseif(is_object($cart) && $cart->invoice_number!=''){
			//We need more parameters
			$post_data = 'invoice_number='.$cart->invoice_number
					.'&invoice_date='.$cart->invoice_date
					.'&merchant_code'.$cart->merchant_code
					.'&terminal_code'.$cart->terminal_code
					;
		}else{
			// There are no enough parameters
			return false;
		}
		// Set parameters to post.
		curl_setopt($curl_session, CURLOPT_POSTFIELDS, $post_data);

		// Get returning data
		$output = curl_exec($curl_session);
		// Close CURL session
		curl_close($curl_session);
		// Create a xml parser
		$parser = xml_parser_create();
		// Parse XML
		xml_parse_into_struct($parser, $output, $values);
		// Free the parser
		xml_parser_free($parser);

		// Load parsed data and make it ready to use
		$this->response = NULL;
		foreach($values as $res_item){
			$tag = strtolower($res_item['tag']);
			$this->response->$tag = $res_item['value'];
		}

		// Return object of parsed data
		return $this->response;
	}

	/**
	 * This function is needed to parse xml data
	 * and is just for internal use.
	 */
	function contents($parser,$data){
		$this->response = $data;
	}

	/**
	 * This function is needed to parse xml data
	 * and is just for internal use.
	 */
	function startTag($parser,$data) {
		// Do nothing
	}

	/**
	 * This function is needed to parse xml data
	 * and is just for internal use.
	 */
	function endTag($parser,$data){
		// Do nothing
	}
}
// End of file: pasargad.php