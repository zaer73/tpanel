<?php
namespace App\Containers\Payment;

use Auth;

class MellatPaymentContainer implements PaymentContainer {

	use \App\Containers\Payment\Mellat\MellatErrors;

	const URL = 'https://pgws.bpm.bankmellat.ir/pgwchannel/services/pgw?wsdl',
		  PAYMENT_URL = 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat';

	private $client, $params, $username, $password, $terminal_id;

	private function setConnectionParams(){
		$this->username = config('payment.gateways.mellat.username');
		$this->password = config('payment.gateways.mellat.password');
		$this->terminal_id = (int) config('payment.gateways.mellat.terminal_id');
		$this->callback = route('checkout.callback');
	}

	public function connect(){
		try { 
			$this->client = new \SoapClient(self::URL);
		} catch (\Exception $e) { 
			throw new \Exception($e->getMessage()); 
		}
		$this->setConnectionParams();
		return $this;
	}

	protected function setPayParams($amount, $orderId){
		$this->params = [
			'terminalId' => $this->terminal_id,
			'userName' => $this->username,
			'userPassword' => $this->password,
			'orderId' => $orderId,
			'amount' => (int) $amount,
			'localDate' => date('Ymd'),
			'localTime' => date('His'),
			'additionalData' => json_encode([
				'gateway' => 'mellat'
			]),
			'callBackUrl' => $this->callback,
			'payerId' => 0
		];
		return $this->client;
	}

	protected function setVerifyParams($orderId, $refrenceId){
		$this->params = [
			'terminalId' => $this->terminal_id,
			'userName' => $this->username,
			'userPassword' => $this->password,
			'orderId' => $orderId,
			'saleOrderId' => $orderId,
			'saleReferenceId' => $refrenceId
		];
		return $this->client;
	}

	public function payment($amount, $orderId){
		$RefId = $this->connect()->setPayParams($amount, $orderId)->bpPayRequest($this->params)->return;
		if($RefId[0] != 0){
			return [
				'RefId' => $RefId,
				'error' => $this->errors($RefId)
			];
		}
		return [
			'RefId' => explode(',', $RefId)[1],
			'url' => self::PAYMENT_URL,
			'amount' => Auth::user()->invoice
		];
	}

	public function verify($orderId, $refrenceId){
		$result = $this->connect()->setVerifyParams($orderId, $refrenceId)->bpVerifyRequest($this->params)->return;
		return $result;
	}

	public function errors($id){
		return $this->getErrors()[$id];
	}

}