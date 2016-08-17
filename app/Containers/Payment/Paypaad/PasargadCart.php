<?php
namespace App\Containers\Payment\Paypaad;
/**
 * @version		pasargad.php 1.0 2010-10-26
 * @package		Pasargad
 */

/**
 * Pasargad Cart Class
 * This class will help you make or save a pasargad cart object.
 */
class PasargadCart {
	public $time_stamp = '';			// String	This will load in constructor by default. Format-> "Y/m/d H:i:s"
	public $invoice_date = '';			// String	Any date that you use in your system
	public $invoice_number = '';		// String
	public $merchant_code = '';		// String	This will load in constructor from config file.
	public $terminal_code = '';		// String	This will load in constructor from config file.
	public $redirect_address = '';		// String	This will load in constructor from config file.
	public $referrer_address = '';		// String	This will load in constructor from config file.
	public $delivery_days = 0;			// Integer	This will load in constructor from config file.
	public $total_amount = 0;			// Integer
	public $buyer_name = '';			// String
	public $buyer_tel = '';			// String
	public $delivery_address = '';		// String
	public $cart = array();			// Array	Array of cart items

	/**
	 * Constructor
	 *
	 * This function just adds parameters which are predefined in the class.
	 * @param	array	Array of needed parameters
	 */
	function __construct($data=array()){
		// Make time stamp
		$this->time_stamp = date('Y/m/d H:i:s');
		// Load config data in object
		$this->merchant_code = config('payment.gateways.pasargad.merchant_code');
		$this->terminal_code = config('payment.gateways.pasargad.terminal_code');
		$this->redirect_address = route('checkout.callback');
		$this->referrer_address = route('checkout.callback');
		$this->delivery_days = 0;
		// If there is any data
		if(count($data)>0){
			foreach($data as $var => $value){
				// Load every data except cart
				if($var!='cart'){
					// Make params ready to prevent from problems.
					// This will strip all html tags.
					$value = strip_tags($value);
					// This will strip OS return symbols (\n or \r)
					$value = str_replace(array("\n","\r"), ' ', $value);
					$this->$var = $value;
				}
				// Now assign cart after making it ready
				if($var == 'cart') $this->cart = $this->makeProductItems($value);
			}
		}
    }

	/**
	 * Constructor
	 * for PHP 4
	 * This function just adds parameters which are predefined in the class.
	 * @param	array	Array of needed parameters
	 */
	function PasargadCart($data=array()){
		$this->__construct($data);
	}

	/**
	 * Make product items ready to use in the cart
	 * 
	 * @param	array	Array of product items
	 * @return	array	Array of cart item objects
	 */
	function makeProductItems($products = array()){
		// Define default values which every product item needs
		$content = '';		// Name or anything which user need to know about this product
		$count = 0;			// Quantity of the item
		$fee = 0;			// Unit price of the item.
		$description = '';	// Description of the item
		$result = array();

		if(count($products)>0){ // If there is any products
			foreach($products as $product){
				$item = [];
				// Create default and necessary parameters
				$item['content'] = $content;
				$item['count'] = $count;
				$item['fee'] = $fee;
				$item['description'] = $description;
				// Assign item's defined parameters
				if(is_array($product) && count($product)>0) {
					foreach($product as $key => $value){
						// Make params ready to prevent from problems.
						// This will strip all html tags.
						$value = strip_tags($value);
						// This will strip OS return symbols (\n or \r)
						$value = str_replace(array("\n","\r"), ' ', $value);
						// Add to Item
						$item['$key'] = $value;
					}
				}
				// Calculate amount parameter
				$item['amount'] = $item['fee'] * $item['count'];
				// Add to results
				$result[] = $item;
			}
		}
		return $result;
	}

}