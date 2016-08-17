<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class PaymentController extends Controller
{

	private $container, $onSuccess = 'http://tpanel.dev/#/shop/lines';

	public $gatewayUrl, $gateway;

    public function __construct($gateway){
        $this->gateway = $gateway;
    	$container = $gateway['container'];
        $this->container = new $container;

    }

    public function move(){
    	$payment = Auth::user()->payments()->create([
    		// 'invoice_id' => Auth::user()->invoice->id,
            'gateway' => $this->gateway['title']
    	]);
        if(Auth::user()->registration_payment && Auth::user()->registration_payment->status == 0)
        {
            Auth::user()->registration_payment()->update([
                'payment_id' => $payment->id
            ]);
        } else {
            $latest_upgrade = Auth::user()->creditUpgrades()->whereStatus(0)->orderBy('id', 'desc')->first();
            $latest_upgrade->update([
                'payment_id' => $payment->id
            ]);
        }
        $result = $this->container->payment(1100, $payment->id);
        if(isset($result['error'])){
            $payment->RefId = $result['RefId'];
            $payment->save();
            $url = route('checkout.unsuccessful', ['error' => $result['error']]);
            return redirect($url);
        }
        $result['orderId'] = $payment->id;
        return view('financial.move', [
            'data' => $result
        ]);
    }

    public function successfulPayment($request){
        $result = $this->container->verify($request->SaleOrderId, $request->SaleReferenceId);
        if($result != 0){
            $error = $this->container->errors($request->ResCode);
            $url = route('checkout.unsuccessful', ['error' => $error]);
            return redirect($url);
        }
        $payment = \App\Payment::where('SaleReferenceId', $request->SaleReferenceId)->update([
            'RefId' => $request->RefId,
            'ResCode' => $request->ResCode,
            'SaleOrderId' => $request->SaleOrderId,
            'SaleReferenceId' => $request->SaleReferenceId,
            'CardHolderInfo' => $request->CardHolderInfo
        ]);
        $this->updateInvoice();
        $financialController = new FinancialController;
        $financialController->successfulPayment();
        $url = route('checkout.successful');
        return redirect($url);
    }

    public function unsuccessfulPayment($request){
        $error = $this->container->errors($request->ResCode);
        $url = route('checkout.unsuccessful', ['error' => $error]);
        return redirect($url);
    }

    private function updateInvoice(){
     $invoice = Auth::user()->invoice()->update([
         'status' => 1
     ]);
    }

}
