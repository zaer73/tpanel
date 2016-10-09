<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Controllers\PaymentController as Payment;
use App\Services\PlanChooserService;

class FinancialController extends Controller
{
    
	public function getInvoice(){
		return Auth::user()->invoice()->with(['transactionsConnections.transaction'])->first();
	}

	public function getGateways(){
		$to_return = [];
		$gateways = config('payment.gateways');
		foreach($gateways as $key => $value){
			$to_return[$key]['title'] = trans($value['title']);
			$to_return[$key]['logo'] = $value['logo'];
		}
		return $to_return;
	}

	public function movingToGateway(Request $request){
		$gateway = config('payment.gateways.'.$request->gateway);
		if(!$gateway) abort(403);
		$payment = new Payment($gateway);
		return $payment->move();
	}

	public function successfulPayment(){
		if(Auth::user()->registration_payment && Auth::user()->registration_payment->status == 0)
		{
			$this->setPlan(Auth::user()->registration_payment->plan_id);
			Auth::user()->registration_payment->update([
				'status' => 1,
			]);
			return;
		}

		$creditUpgrade = Auth::user()->creditUpgrades()->latest()->first();
		$this->setCredit($creditUpgrade->value);
		$creditUpgrade->update([
			'status' => 1
		]);
		// $invoice = Auth::user()->successfulInvoice()->with(['transactionsConnections.transaction'])->first();
		// foreach($invoice->transactionsConnections as $connection){
		// 	if($connection->transaction->type == 'line'){
		// 		$this->setLine($connection->transaction->target_id);
		// 	} elseif($connection->transaction->type == 'credit'){
		// 		$this->setCredit($connection->transaction->value);
		// 	} elseif($connection->transaction->type == 'module'){
		// 		$this->setModule($connection->transaction->target_id);
		// 	}
		// 	$connection->transaction->update([
		// 		'status' => 1
		// 	]);
		// }
	}

	private function setLine($line_id){
		$role = userRole(Auth::user());
		$line = \App\Line::whereId($line_id)->first();
		$line->update([
			$role.'_id' => Auth::id(),
			$role.'_expires_at' => date('Y-m-d H:i:s', strtotime('+1 year'))
		]);
	}

	private function setCredit($cash){
		$sms_fee = sms_fee($cash, Auth::user());
		Auth::user()->unit_fee = $sms_fee;
		Auth::user()->save();
		$credit_to_add = (($cash/$sms_fee)*10)/10;
		if( supervisor_id(Auth::user()) ){
			$supervisor = \App\User::whereId(supervisor_id(Auth::user()))->first();
	        $supervisor->update([
	            'credit' => $supervisor->credit + -1*$credit_to_add
	        ]);
	    }
		event(new \App\Events\Financial\CreditChanged($credit_to_add, 'plus'));
	}

	private function setModule($module_id){
		$module = \App\Module::findOrFail($module_id);
		Auth::user()->permissions()->update([$module->module_key => 1]);
	}

	private function setPlan($plan_id){
		$service = app(PlanChooserService::class);
		$service->set($plan_id, Auth::id());
	}

	public function getTransactions(){
		// return Auth::user()->transactions()->orderBy('id', 'desc')->with(['invoicesConnections.payment'])->get();
		$dataTable = \Yajra\Datatables\Facades\Datatables::usingEloquent(
	            \App\Transaction::where('user_id', auth()->id())->orderBy('id', 'desc')->with(['invoicesConnections.payment'])
	        )->make(true);
	        return $dataTable;
	}

	public function getReport(){
		if( Auth::user()->role == 2 ) {

			$dataTable = \Yajra\Datatables\Facades\Datatables::usingEloquent(
	            \App\SMSTransaction::orderBy('id', 'desc')
	        )->make(true);
	        return $dataTable;

		}

		$dataTable = \Yajra\Datatables\Facades\Datatables::usingEloquent(
	            \App\SMSTransaction::where('user_id', auth()->id())->orderBy('id', 'desc')
	        )->make(true);
	        return $dataTable;

	}

	public function unsuccessful($error){
		return view('financial.unsuccessful')->with(['error' => $error]);
	}

	public function successful(){
		return view('financial.successful');
	}

	public function callback(Request $request){
		$paymentIns = \App\Payment::where('id', $request->SaleOrderId)->first();
		$gateway = config('payment.gateways.'.$paymentIns->gateway);
        $payment = new Payment($gateway);
		if($request->ResCode == 0){
			return $payment->successfulPayment($request);
		}
		$paymentIns->ResCode = $request->ResCode;
		$paymentIns->save();
		return $payment->successfulPayment($request);
    }

    public function postBill(Request $request){
    	$this->validate($request, [
    		'number' => 'required|regex:/[0-9]+/|max:30',
    		'bank_name' => 'required|max:50',
    		'bank_code' => 'required|max:50',
    		'value' => 'required|regex:/[0-9]+/|max:20',
    		'description' => 'max:100'
    	]);
    	Auth::user()->bills()->create([
    		'number' => $request->number,
    		'bank_name' => $request->bank_name,
    		'bank_code' => $request->bank_code,
    		'value' => $request->value,
    		'description' => $request->description,
    	]);
    	return [
    		'result' => 'success',
    		'message' => trans('bill_created'),
    		'reset' => true
    	];
    }

    public function getBillReport()
    {
    	$bills = [];

    	foreach (auth()->user()->children()->select('id', 'username')->get() as $child) {
    		foreach ($child->bills as $bill) {
    			$bills[] = [
    				'user' => $child,
    				'bill' => $bill
    			];
    		}
    	}

    	return $bills;
    }

    public function offlineCheckout(){
    	$invoice = Auth::user()->invoice()->with(['transactionsConnections.transaction'])->first();
    	if($invoice->abs_value == 0 || !count($invoice->transactionsConnections)) return;
    	if(Auth::user()->credit < $invoice->abs_value){
    		return [
    			'result' => 'danger',
    			'message' => trans('credit_not_enough')
    		];	
    	}
    	foreach($invoice->transactionsConnections as $connection){
			if($connection->transaction->type == 'line'){
				$this->setLine($connection->transaction->target_id);
			} elseif($connection->transaction->type == 'credit'){
				$this->setCredit($connection->transaction->value);
			} elseif($connection->transaction->type == 'module'){
				$this->setModule($connection->transaction->target_id);
			} elseif($connection->transaction->type == 'plan'){
				$this->setPlan($connection->transaction->target_id);
			}
			$connection->transaction->update([
				'status' => 1
			]);
		}

		event(new \App\Events\Financial\CreditChanged($invoice->abs_value, 'minus'));
		$invoice->update(['status' => 1]);
		return [
			'result' => 'success',
			'message' => trans('successful_shop')
		];
    }

}
