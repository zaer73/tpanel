<?php
namespace App\Helpers\API;
use cURL, Auth;

trait SMS {

	public function selectProvider($line, $queueName, $flash){
        if(is_array($line) && count($line) == 0) return 'international';
        if($queueName == 'internationalSMS' || $queueName == 'brandSMS' || $flash == 'true') return 'international';
        if(substr($line->number, 0, 4) == '1000' || substr($line->number, 0, 5) == '50001'){
            if($line->rahyab) return 'rahyab';
            return 'gama';
        }
        if(substr($line->number, 0, 2) == '021' || substr($line->number, 0, 2) == '026'){
        	return 'asanak';
        }
	}

	public function sendSMS($to, $message, $line_id, $sms_id, $send_on=null, $queueName, $flash=false, $brand=null, $group_hash=null, $user=null){
        $line = [];
        $line_number = 0;
        if(!$brand && $queueName != 'internationalSMS'){
		  $line = \App\Line::whereId($line_id)->orWhere('number', $line_id)->first();
          if(!$line) abort(404);
          $line_number = $line->number;
        }
		$provider = $this->selectProvider($line, $queueName, $flash);
        if($queueName == 'scheduledSMS'){
            $user = \App\User::whereRole(2)->first();
        }
        $api_key = (empty($user)) ? Auth::user()->apikey : $user->apikey;
        $api_url = config('api.url');
		$response = cURL::post($api_url.'/send/'.$provider, [
            'receiver' => $to,
            'message' => $message,
            'key' => $api_key->public_key,
            'secret' => bcrypt($api_key->secret_key),
            'line' => $line_number,
            'sms_id' => $sms_id,
            'later' => time_difference($send_on),
            'queueName' => $queueName,
            'flash' => $flash,
            'brand' => $brand,
            'group_hash' => $group_hash
        ]);

	}

}
