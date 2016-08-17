<?php
namespace App\Containers\Payment;

interface PaymentContainer {

	public function connect();

	public function verify($orderId, $refrenceId);

	public function payment($amount, $orderId);

	public function errors($id);

}