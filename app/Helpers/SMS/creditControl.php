<?php
namespace App\Helpers\SMS;
use Auth;

trait creditControl{

	public function controlCredit($line, $type, $numbers, $text, $smart=false, $no_trans=false, $no_die=false){
        $line = \App\Line::whereId($line)->orWhere('number', $line)->firstOrFail();
        $system_number = \App\AdminSetting::whereKey('system_number')->first();
        if($line->general || ($system_number && $system_number->value == $line->number)){
            $user = Auth::user();
        } elseif($line->user_id == 0){
            $user = \App\User::whereId($line->agent_id)->firstOrFail();
        } else {
            $user = \App\User::whereId($line->user_id)->firstOrFail();
        }
        $line = $line->number;
        $numbers = $this->checkBlackList($numbers, $user);
        $totalCost = $this->message_pages($line, $text)*total_cost($numbers, $text, $smart, false, $user);
        if($totalCost > $user->credit && !$no_die){
            die(
            json_encode([
                'result' => 'exception',
                'errors' => trans('not_enough_credit'),
            ]));
        }
        if($user->credit <= 100){
            $this->sendCreditReminder($user);
        }
        if($no_trans == 'no_trans') return $totalCost;
        $this->saveSMSTransaction($type, $totalCost, $user);
        return $totalCost;
    }

    private function sendCreditReminder($user){
        if($user->settings()->where('sms_balance', 1)->count('id') > 0 && !empty($user->mobile)){
            $todays = \App\SMSTransaction::whereUserId($user->id)
                ->where('type', 'credit_reminder')
                ->whereDate('created_at', '>=', date('Y-m-d'))
                ->count();
            if( $todays > 0 ) return;
            $system_number = \App\AdminSetting::whereKey('system_number')->first()->value;
            $line = \App\Line::whereNumber($system_number)->first()->id;
            $this->saveSMSTransaction('credit_reminder', 0, $user);
            event(new \App\Events\SMS(0, $user->mobile, trans('credit_lower_than_100'), $line, $user->id, 'credit'));
        }
    }

    public function saveSMSTransaction($type, $value, $user=null){
        $user = (empty($user)) ? Auth::user() : $user;
        $user->smsTransactions()->create([
            'type' => $type,
            'value' => $value,
            'last_credit' => $user->credit
        ]);
    }

    public function sendingLimit($request, $numbers){
        $limit = 0;
        if(isset($request['sendingCountAbsoluteMin']) || isset($request['sendingCountAbsoluteMax']) || isset($request['sendingCountRelative'])){
            if ($request['sendingCountRelative'] == -1) {
               $limit = 0; 
            }
            else {    
                if(isset($request['sendingCountAbsoluteMin'])){
                    $limit = $request['sendingCountAbsoluteMin'];
                } else {
                    $limit = $request['sendingCountRelative'];
                }
            }
        }
        if(is_int($numbers)) return $limit;
        if($limit > 0) $numbers = array_chunk($numbers->toArray(), $limit)[0];
        return $numbers;
    }

    public function message_pages($line, $text){
        $length = strlen($text);
        if(preg_match("/^50001/", $line)){
            if(preg_match("/^[ا-ی]/", $text)){
                return $this->gamaPersian($length);
            }
            return $this->gamaLatin($length);
        } else {
            if(preg_match("/^[ا-ی]/", $text)){
                return $this->otherPersian($length);
            }
            return $this->otherLatin($length);
        }
    }

    private function gamaPersian($length){
        if($length <= 70) return 1;
        if($length <= 132) return 2;
        if($length <= 198) return 3;
        if($length <= 264) return 4;
        if($length <= 330) return 5;
        if($length <= 396) return 6;
        if($length <= 462) return 7;
        if($length <= 528) return 8;
        if($length <= 594) return 9;
        if($length <= 660) return 10;
        return false;
    }

    private function gamaLatin($length){
        if($length <= 140) return 1;
        if($length <= 264) return 2;
        if($length <= 396) return 3;
        if($length <= 528) return 4;
        if($length <= 660) return 5;
        if($length <= 792) return 6;
        if($length <= 924) return 7;
        if($length <= 1056) return 8;
        if($length <= 1188) return 9;
        if($length <= 1320) return 10;
        return false;
    }

    private function otherPersian($length){
        if($length <= 70) return 1;
        if($length <= 134) return 2;
        if($length <= 201) return 3;
        if($length <= 268) return 4;
        if($length <= 335) return 5;
        if($length <= 402) return 6;
        if($length <= 469) return 7;
        if($length <= 536) return 8;
        if($length <= 603) return 9;
        if($length <= 670) return 10;
        return false;
    }

    private function otherLatin($length){
        if($length <= 160) return 1;
        if($length <= 306) return 2;
        if($length <= 459) return 3;
        if($length <= 612) return 4;
        if($length <= 765) return 5;
        if($length <= 918) return 6;
        if($length <= 1071) return 7;
        if($length <= 1224) return 8;
        if($length <= 1377) return 9;
        if($length <= 1530) return 10;
        return false;
    }

    private function checkBlackList($numbers, $user=null){
        $user = (empty($user)) ? Auth::user() : $user;
        if( !$user ) return $numbers;
        $blacklist = $user->blacklists()->whereStatus(0)->lists('number')->toArray();
        if(is_int($numbers)) return $numbers;
        $numbers = array_diff($numbers, $blacklist);
        // if(!count($numbers)){
        //     die(json_encode([
        //         'result' => 'blacklist',
        //         'message' => trans('number_in_blacklist', ['number' => $number])
        //     ]));
        // }
        return $numbers;
        // foreach($numbers as $number){
        //     if(in_array($number, $blacklist)){
        //         die(json_encode([
        //             'result' => 'blacklist',
        //             'message' => trans('number_in_blacklist', ['number' => $number])
        //         ]));
        //     }
        // }
    }

}