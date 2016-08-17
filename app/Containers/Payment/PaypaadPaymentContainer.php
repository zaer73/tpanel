<?php
namespace App\Containers\Payment;
use App\Containers\Payment\Paypaad\Pasargad;
use App\Containers\Payment\Paypaad\PasargadCart;
use cURL, Auth;

class PaypaadPaymentContainer implements PaymentContainer {

	const URL = 'https://pep.shaparak.ir/gateway.aspx';
	const CHECK_URL = 'ttps://pep.shaparak.ir/CheckTransactionResult.aspx';

	protected $client, $callback, $merchant_code, $terminal_code;

	public function setConnectionParams(){
		$this->merchant_code = config('payment.gateways.pasargad.merchant_code');
		$this->terminal_code = config('payment.gateways.pasargad.terminal_code');
		$this->callback = route('checkout.callback');
	}

	public function connect(){
		$this->setConnectionParams();
		$client = $cURL::post(self::URL);
		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, self::URL);
		// curl_setopt($ch, CURLOPT_POST, true);
		// $params = [];
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		// $client = curl_exec($ch);

		// // close cURL resource, and free up system resources
		// curl_close($ch);
		dd($client);
	}

	private function generateXML(){
		$cart_data = [
			'buyer_name' => Auth::user()->name,
			'buyer_tel' => '',
			'total_amount' => (int)Auth::user()->invoice->value,
			'delivery_days' => 0,
			'delivery_address' => '',    
			'invoice_date' => Auth::user()->invoice->created_at->format('Y/m/d H:i:s'),
			'invoice_number' => Auth::user()->invoice->id,
			'cart' => [
				[
					'content' => 'Order',
					'fee' => (int)Auth::user()->invoice->value,
					'count' => 1,
				]
			]
		];
		$cart = new PasargadCart($cart_data);
		$pasargad = new Pasargad();
		$xml = $pasargad->createXML($cart);
		$sign = $pasargad->sign($xml);
		dd($sign);
	}

	private function process($amount, $invoiceNumber){
		$this->setConnectionParams();
		$processor = new RSAProcessor(app_path("Containers/Payment/Pasargad/certificate.xml"),RSAKeyType::XMLFile);
		$timeStamp = date("Y/m/d H:i:s");
		$invoiceDate = date("Y/m/d H:i:s"); //تاريخ فاكتور
		$action = "1003"; 	// 1003 : براي درخواست خريد 
		$data = "#". $this->merchant_code ."#". $this->merchant_code ."#". $invoiceNumber ."#". $invoiceDate ."#". $amount ."#". $this->callback ."#". $action ."#". $timeStamp ."#";
		$data = sha1($data,true);
		$data =  $processor->sign($data); // امضاي ديجيتال 
		return base64_encode($data); // base64_encode 
	}

	public function verify($orderId, $refrenceId){
		
	}

	public function payment($amount, $orderId){
		$this->generateXML();
	}

	public function errors($id){

	}

}