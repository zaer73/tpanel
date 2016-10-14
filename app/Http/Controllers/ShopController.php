<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Line, App\Module, App\Special, \App\Invoice, \App\InvoiceTransactionConnection as Connection, \App\Transaction;
use Auth;

class ShopController extends Controller
{
    public function getLineList(){
    	$role = userRole(Auth::user());
        $invoices = Auth::user()->invoices()->select('id')->whereStatus(0)->lists('id');
        $invoice_transactions_connection = Connection::whereIn('invoice_id', $invoices)->lists('transaction_id');
        $already_added_lines = Transaction::whereType('line')->whereIn('id', $invoice_transactions_connection)->lists('target_id');
    	if($role == 'agent'){
    		return Line::whereNotIn('id', $already_added_lines)->where(function($query){
    			$query->whereAgentId(0)
    				  ->orWhereRaw('agent_expires_at < NOW()');
    		})->whereUserId(0)->whereStatus(0)->whereShoppable(1)->get();
    	}
    	if($role == 'user'){
    		$agent = Auth::user()->agent_id;
    		return Line::whereNotIn('id', $already_added_lines)->whereAgentId($agent)->where(function($query){
    			$query->whereUserId(0)
    				  ->orWhereRaw('user_expires_at < NOW()');
    		})->whereRaw('agent_expires_at > NOW()')->whereStatus(0)->get();
    	}
    	return Line::all();
    }

    public function getModulesList(){
        $role = userRole(Auth::user());
        $invoices = Auth::user()->invoices()->select('id')->whereStatus(0)->lists('id');
        $invoice_transactions_connection = Connection::whereIn('invoice_id', $invoices)->lists('transaction_id');
        $already_added_modules = Transaction::whereType('module')->whereIn('id', $invoice_transactions_connection)->lists('target_id');
    	return Module::whereStatus(0)
                ->whereNotIn('id', $already_added_modules)
                // ->whereUserId(supervisor_id(Auth::user()))
                ->get();
    }

    public function getExtensionList(){
    	$role = userRole(Auth::user());
        if($role == 'admin') return [];
    	return Line::where($role.'_id', Auth::id())
            ->where(function($query) use ($role){
                $query->
                    whereRaw('DATE(`'.$role.'_expires_at`) < DATE(NOW() + INTERVAL 30 DAY)')
                    ->orWhereRaw('DATE(`'.$role.'_expires_at`) < DATE(NOW())');
            })->where('shoppable', 1)->get();
    }

    public function getSpecialsList(){
    	$role = userRole(Auth::user());
    	if($role == 'user'){
    		$agent = Auth::user()->agent_id;
    		return Special::where('status', 0)->where(function($query) use ($agent){
    			$query->whereGlobal(1)
    				  ->orWhere('agent_id', $agent);
    		})->whereIn('type', [0, 2])->get();
    	}
    	if($role == 'agent'){
    		return Special::where('status', 0)->where('global', 1)->whereIn('type', [0, 1])->get();
    	}
    	return Special::all();
    }

    public function addLineToInvoice(Request $request){
        $role = userRole(Auth::user());
        $line = Line::whereId($request->line_id)
            // ->where($role.'_id', Auth::user()->id)
            // ->where(function($query) use ($role){
            //     $query->where($role.'_id', 0)
            //     ->orWhere($role.'_id', Auth::id());
            // })
            ->firstOrFail();
        $line->{$role.'_expires_at'} = date('Y-m-d H:i:s', strtotime('+1 year'));
        $line->save();
        event(new \App\Events\Financial\Transaction($line->value, 'minus', Auth::user(), 'line', $line->id, trans('transaction_buy_line', ['number' => $line->number])));
    }

    public function upgradeByCode(Request $request){
        $admin_id = admin_id();
        $parent = (userRole(Auth::user()) == 'agent') ? $admin_id : Auth::user()->parent;
        $code = \App\Charge::where('code', $request->code)->whereUserId($parent)->first();
        if(!$code){
            return [
                'result' => 'exception',
                'errors' => trans('charge_code_doesnt_exist')
            ];
        }
        if($code->expired_bool || strtotime('now') > strtotime($code->expires_at)){
            return [
                'result' => 'exception',
                'errors' => trans('charge_code_expired')
            ];
        }
        auth()->user()->transactions()->create([
            'value' => $code->value,
            'last_credit' => auth()->user()->credit ?: 0,
            'type' => 'charge',
            'target_id' => auth()->user()->id,
            'description' => 'credit_upgrade_by_charge',
            'code' => rand(10000000, 99999999)
        ]);
        event(new \App\Events\Financial\CreditChanged($code->credit, 'plus'));
        $code->expired = 1;
        $code->save();
        return [
            'result' => 'success',
            'message' => trans('credit_upgraded_successfully'),
            'reset' => true
        ];
    }

    public function upgradeByCash(Request $request){
        $this->validate($request, [
            'credit' => 'required|numeric|max:10000000|min:100'
        ]);
        if( Auth::user()->role == 0 )
        {
            $totalCredit = $request->credit/sms_fee( $request->credit, Auth::user() );
            $agent = \App\User::whereId(supervisor_id(Auth::user()))->first();
            if( !$agent || $agent->credit < $totalCredit )
            {
                return [
                    'result' => 'fail',
                    'errors' => trans('please_call_the_manager')
                ];
            }

        }
        // event(new \App\Events\Financial\Transaction($request->credit, 'plus', Auth::user(), 'credit', 0, trans('cash_credit_transaction', ['credit' => $request->credit])));
        Auth::user()->creditUpgrades()->create([
            'value' => $request->credit
        ]);
        return [
            'result' => 'success',
            'reset' => true
        ];
    }

    public function addModuleToInvoice(Request $request){
        $parentIsAvailable = false;
        if($parentIsAvailable){
            $parent_id = parent_id(Auth::user());
            $module = Module::whereId($request->module_id)->whereUserId($parent_id)->firstOrFail();
        } else {
            $module = Module::whereId($request->module_id)->firstOrFail();
        }
        event(new \App\Events\Financial\Transaction(
            $module->value, 
            'minus', 
            Auth::user(), 
            'module', $module->id, 
            trans('buy_module', ['module' => trans('permission_'.$module->module_key)])
        ));
    }

    public function removeModuleFromInvoice($id){
        $transaction = \App\Transaction::whereId($id)->first();
        $invoice_transactions_connection = \App\InvoiceTransactionConnection::whereTransactionId($id)->first();
        $invoice_id = $invoice_transactions_connection->invoice_id;
        $invoice = \App\Invoice::whereId($invoice_id)->first();
        $invoice->value = $invoice->value - $transaction->value;
        $invoice->save();
        $invoice_transactions_connection->delete();
        $transaction->delete();
    }


}
