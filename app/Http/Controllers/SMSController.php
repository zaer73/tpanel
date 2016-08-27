<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SMS, App\TrashedSMS;
use App\User, App\ContactGroup;
use App\NumberBank as Bank;
use App\Jobs\GroupSMS;
use Auth, Excel;

class SMSController extends Controller
{
    use \App\Helpers\SMS\creditControl;
    use \App\Helpers\Upload\ExcelImporter;

    public function __construct(Request $request){
        $this->middleware('auth');
    }

    private function lineValidator(){
        $validator = 'required|exists:lines,id';
        $validator = 'required';
        // $user_id = Auth::id();
        // $role = userRole(Auth::user());
        // if($role == 'agent'){
        //     $validator .= ',agent_id,'.$user_id.',user_id,0';
        // } elseif($role == 'user'){
        //     $validator .= 'user_id,'.$user_id;
        // }
        return $validator;
    }

    private function saveInput($request){
        $input = new \App\SMSInput;
        $input->inputs = json_encode($request);
        $input->save();
        return $input->id;
    }

    public function sendSingle(Request $request){
        if(Auth::user()->cannot('send_single_sms', Auth::user()->permissions)) abort('403');
        if($request->has('number') && is_array($request->number)){
            $number = $request->number['number'];
        } else {
            $number = $request->customNumber;
            if(!preg_match('/(090|091|092|093|90|91|92|93){1}\d{8}+/', $number)){
                return [
                    'result' => 'exception',
                    'errors' => trans('custom_number_is_not_valid', ['number' => $number])
                ];
            }
        }
        // $this->validate($request, [
        //     'text' => 'required|max:500',
        //     'line' => $this->lineValidator(),
        //     'customNumber' => ['required_without:number','regex:/(090|091|092|093|90|91|92|93){1}\d{8}+/'],
        //     'scheduled_id' => 'exists:schedules,id,user_id,'.Auth::id()
        // ]);        
        $input_id = $this->saveInput($request->all());
        if(!isset($isModal)){
            $totalCost = $this->controlCredit($request->line, 'single', [$number], $request->text, false, 'no_trans');
            if($request->get('is_confirmed') != 'on' && $request->get('confirm') != 'no_confirm'){
                return [
                    'result' => 'group_confirm',
                    'totalCost' => $totalCost,
                    'numbers' => count($number)
                ];
            }
        }
        $this->controlCredit($request->line, 'single', [$number], $request->text, false, 'no_trans');
        $ok_numbers = $this->checkBlackList([$number]);
        $message_scheduled = trans('sms_scheduled');
        $sms_to_group_sent = trans('sms_to_group_sent');
        $black_numbers = array_diff([$number], $ok_numbers);
        if(count($black_numbers) > 0){
            $message_scheduled = trans('sms_scheduled_except', ['numbers' => implode(' , ', $black_numbers)]);
            $sms_to_group_sent = trans('sms_to_group_sent_except', ['numbers' => implode(' , ', $black_numbers)]);
        }
        $numbers = $ok_numbers;
        if(!$request->has('scheduled_id')){
            if(count($black_numbers) < 1){
                event(new \App\Events\SMS\Single($input_id, $request->text, $number, $request->line, $request->sendOn, $request->flash));
            }
        } else {
            if(count($black_numbers) < 1){
                event(new \App\Events\SMS\ScheduledMessage($request->text, [$number], $request->line, $request->flash, $request->scheduled_id));
            }
            return [
                'result' => 'success',
                'message' => $message_scheduled,
                'reset' => true,
            ];
        }
        return [
            'result' => 'success',
            'message' => $sms_to_group_sent,
            'reset' => true,
        ];
    }

    public function sendGroup(Request $request){
        if(Auth::user()->cannot('send_group_sms', Auth::user()->permissions)) abort('403');
        $numbers = [];
        $group_id = $request->group;
        if($request->has('contacts') && count($request->contacts)){
            foreach($request->contacts as $contact){
                array_push($numbers, $contact['number']);
            }
        } 
        if($request->has('numbers')) {
            $beforeExplode = str_replace([',', "\n"], '%', $request->numbers);
            $explodedNumbers = explode('%', $beforeExplode);
            $explodedNumbers = array_filter($explodedNumbers);
            $numbers = \App\Contact::whereUserId(Auth::id())->whereIn('id', $explodedNumbers)->lists('number')->toArray();
            if(!count($numbers)){
                $invalidNumbers = [];
                foreach($explodedNumbers as $number){
                    if(!preg_match('/(090|091|092|093|90|91|92|93){1}\d{8}+/', $number)){
                        array_push($invalidNumbers, $number);
                    }
                    array_push($numbers, $number);
                }
                if(count($invalidNumbers)){
                    $invalidToShow = implode(',', $invalidNumbers);
                    return [
                        'result' => 'exception',
                        'errors' => trans('custom_number_is_not_valid', ['numbers' => $invalidToShow])
                    ];
                }
            } else {
                $isModal = true;
            }
        } 
        if($request->has('groups')){
            $group_ids = [];
            foreach($request->groups as $group){
                if(isset($group['contacts'])){
                    foreach($group['contacts'] as $contact){
                        $numbers[] = $contact['number'];
                    }
                }
            } 
        }
        $numbers = array_unique($numbers);
        if(count($numbers) < 1) {
            return [
                'errors' => trans('sms_no_contacts_available'),
                'result' => 'exception'
            ];
        }
        $this->validate($request, [
            'text' => 'required',
            'line' => $this->lineValidator(),
            'scheduled_id' => 'exists:schedules,id,user_id,'.Auth::id()
        ]);
        $input_id = $this->saveInput($request->all());
        $totalCost = $this->controlCredit($request->line, 'group', $numbers, $request->text, false, 'no_trans');
        if($request->get('is_confirmed') != 'on' && !isset($isModal) && $request->get('confirm') != 'no_confirm'){
            return [
                'result' => 'group_confirm',
                'totalCost' => $totalCost,
                'numbers' => count($numbers)
            ];
        }
        $ok_numbers = $this->checkBlackList($numbers);
        $message_scheduled = trans('sms_scheduled');
        $sms_to_group_sent = trans('sms_to_group_sent');
        $black_numbers = array_diff($numbers, $ok_numbers);
        if(count($black_numbers)){
            $message_scheduled = trans('sms_scheduled_except', ['numbers' => implode(' , ', $black_numbers)]);
            $sms_to_group_sent = trans('sms_to_group_sent_except', ['numbers' => implode(' , ', $black_numbers)]);
        }
        $numbers = $ok_numbers;
        if(!$request->has('scheduled_id')){
            event(new \App\Events\SMS\Group($input_id, $request->text, $numbers, $request->line, $request->sendOn, $request->flash));
        } else {
            event(new \App\Events\SMS\ScheduledMessage($request->text, $numbers->toArray(), $request->line, $request->flash, $request->scheduled_id));
            return [
                'result' => 'success',
                'message' => $message_scheduled,
                'reset' => true,
            ];
        }
        return [
            'result' => 'success',
            'message' => $sms_to_group_sent,
            'reset' => true,
        ];
    }

    public function resend(Request $request){
        $sms = SMS::whereId($request->id)->first();
        if(!$sms || Auth::user()->cannot('resendSMS', $sms)) abort('403');
        event(new \App\Events\SMS\Single($request->text, $sms->reciever));
    }

    public function deleteSent($id){
        $sms = SMS::whereId($id)->first();
        if(!$sms || Auth::user()->cannot('deleteSMS', $sms)) abort('403');
        $sms->update(['trashed' => '1']);
        Auth::user()->trashed()->create([
            'sms_id' => $sms->id,
            'type' => '0',
            'text' => $sms->text,
            'status' => '-1',
        ]);
        return [
            'result' => 'success'
        ];
    }

    public function restore($id){
        $sms = SMS::whereId($id)->first();
        if(!$sms || Auth::user()->cannot('restoreSMS', $sms)) abort('403');
        $sms->update([
            'trashed' => 0
        ]);
        $trashed = TrashedSMS::whereSmsId($id)->first()->update(['status' => 0]);
    }

    public function destroy($id){
        $sms = TrashedSMS::whereId($id)->whereUserId(Auth::id())->whereStatus('-1')->first();
        if(!$sms) abort('403');
        $sms->update(['status' => '-2']);
    }

    public function sendCity(Request $request){
        if(Auth::user()->cannot('send_sms_by_city', Auth::user()->permissions)) abort('403');
        $this->validate($request, [
            'text' => 'required|max:500',
            'province' => 'required|exists:provinces,id',
            'city' => 'required|exists:cities,id',
            'line' => $this->lineValidator()
        ]);
        $input_id = $this->saveInput($request->all());
        event(new \App\Events\SMS\City($input_id, $request->text, $request->line, $request->province, $request->city, $request->sendOn, $request->all()));
        return [
            'result' => 'success',
            'message' => trans('sms_to_city_sent'),
            'reset' => true,
        ];
    }

    public function sendOccupation(Request $request){
        if(Auth::user()->cannot('send_sms_by_occupation', Auth::user()->permissions)) abort('403');
        $this->validate($request, [
            'text' => 'required|max:500',
            'occupation' => 'required|exists:occupations,id',
            'line' => $this->lineValidator()
        ]);
        $input_id = $this->saveInput($request->all());
        event(new \App\Events\SMS\Occupation($input_id, $request->text, $request->line, $request->occupation, $request->sendOn, $request->all()));
        return [
            'result' => 'success',
            'message' => trans('sms_to_occupation_sent'),
            'reset' => true,
        ];
    }

    public function sendPostalCode(Request $request){
        if(Auth::user()->cannot('send_sms_by_postal_code', Auth::user()->permissions)) abort('403');
        $this->validate($request, [
            'text' => 'required|max:500',
            'postalCode' => 'required|exists:postal_codes,id',
            'line' => $this->lineValidator()
        ]);
        $input_id = $this->saveInput($request->all());
        event(new \App\Events\SMS\PostalCode($input_id, $request->text, $request->line, $request->postalCode, $request->sendOn, $request->all()));
        return [
            'result' => 'success', 
            'message' => trans('sms_to_postal_codes_sent'),
            'reset' => true,
        ];
    }

    public function sendGender(Request $request){
        if(Auth::user()->cannot('send_sms_by_gender', Auth::user()->permissions)) abort('403');
        $this->validate($request, [
            'text' => 'required|max:500',
            'line' => $this->lineValidator()
        ]);
        
        $input_id = $this->saveInput($request->all());
        event(new \App\Events\SMS\Gender($request, $input_id, $request->text, $request->line, $request->sendOn, $request->all()));
        return [
            'result' => 'success',
            'message' => trans('sms_to_gender_sent'),
            'reset' => true,
        ];
    }

    public function genderList(){
        if(Auth::user()->cannot('send_sms_by_gender', Auth::user()->permissions)) abort('403');
        return Auth::user()->genderSMS;
    }

    public function removeGender($id){
        if(Auth::user()->cannot('send_sms_by_gender', Auth::user()->permissions)) abort('403');
        $genderSMS = \App\GenderSMS::whereUserId(Auth::id())->whereId($id)->first();
        if(!$genderSMS) abort(403);
        $genderSMS->update([
            'canceled' => 1
        ]);
        $GenderSMSService = \App::make(\App\Services\GenderSMSService::class);
        $GenderSMSService->cancel($genderSMS->returnId);
    }

    public function sendBrand(Request $request){
        if(Auth::user()->cannot('send_sms_by_brand', Auth::user()->permissions)) abort('403');
        $numbers = [];
        $group_id = $request->group;
        if($request->has('contacts') && count($request->contacts)){
            foreach($request->contacts as $contact){
                array_push($numbers, $contact['number']);
            }
        } 
        if($request->has('numbers')) {
            $explodedNumbers = explode(',', $request->numbers);
            $explodedNumbers = array_filter($explodedNumbers);
            $invalidNumbers = [];
            foreach($explodedNumbers as $number){
                if(!preg_match('/(090|091|092|093|90|91|92|93){1}\d{8}+/', $number)){
                    array_push($invalidNumbers, $number);
                }
                array_push($numbers, $number);
            }
            if(count($invalidNumbers)){
                $invalidToShow = implode(',', $invalidNumbers);
                return [
                    'result' => 'exception',
                    'errors' => trans('custom_number_is_not_valid', ['numbers' => $invalidToShow])
                ];
            }
        } 
        if($request->has('groups')){
            $group_ids = [];
            foreach($request->groups as $group){
                if(isset($group['contacts'])){
                    foreach($group['contacts'] as $contact){
                        $numbers[] = $contact['number'];
                    }
                }
            } 
        }
        $numbers = array_unique($numbers);
        if(count($numbers) < 1) {
            return [
                'errors' => trans('sms_no_contacts_available'),
                'result' => 'exception'
            ];
        }
        $this->validate($request, [
            'text' => 'required|max:500',
            'brand' => 'required|max:35',
            'line' => $this->lineValidator()
        ]);
        $input_id = $this->saveInput($request->all());
        event(new \App\Events\SMS\Brand($input_id, $request->text, $request->line, $numbers, $request->brand, $request->sendOn, $request->flash, $request->all()));
        return [
            'result' => 'success',
            'message' => trans('sms_to_brand_sent'),
            'reset' => true,
        ];
    }

    public function sendMap(Request $request){
        if(Auth::user()->cannot('send_sms_by_map', Auth::user()->permissions)) abort('403');

        $this->validate($request, [
            'text' => 'required|max:500',
            'line' => $this->lineValidator(),
            'amount' => 'required|numeric|min:1'
        ]);

        $selectedRegions = $request->get('selectedPolygon');

        $input_id = $this->saveInput($request->all());

        event(new \App\Events\SMS\Map($input_id, $request->text, $request->line, $selectedRegions, $request->sendOn, $request->all()));

        return [
            'result' => 'success',
            'message' => trans('sms_to_city_sent'),
            'reset' => true,
        ];
    }

    public function sendInternational(Request $request){
        if(Auth::user()->cannot('send_international_sms', Auth::user()->permissions)) abort('403');
        $numbers = [];
        $group_id = $request->group;
        if($request->has('contacts') && count($request->contacts)){
            foreach($request->contacts as $contact){
                array_push($numbers, $contact['number']);
            }
        } 
        if($request->has('numbers')) {
            $explodedNumbers = explode(',', $request->numbers);
            $explodedNumbers = array_filter($explodedNumbers);
            $invalidNumbers = [];
            foreach($explodedNumbers as $number){
                if(!preg_match('/(090|091|092|093|90|91|92|93){1}\d{8}+/', $number)){
                    array_push($invalidNumbers, $number);
                }
                array_push($numbers, $number);
            }
            if(count($invalidNumbers)){
                $invalidToShow = implode(',', $invalidNumbers);
                return [
                    'result' => 'exception',
                    'errors' => trans('custom_number_is_not_valid', ['numbers' => $invalidToShow])
                ];
            }
        } 
        if($request->has('groups')){
            $group_ids = [];
            foreach($request->groups as $group){
                if(isset($group['contacts'])){
                    foreach($group['contacts'] as $contact){
                        $numbers[] = $contact['number'];
                    }
                }
            } 
        }
        $numbers = array_unique($numbers);
        if(count($numbers) < 1) {
            return [
                'errors' => trans('sms_no_contacts_available'),
                'result' => 'exception'
            ];
        }
        $this->validate($request, [
            'text' => 'required|max:500',
        ]);
        $ok_numbers = $this->checkBlackList($numbers);
        $sms_to_group_sent = trans('sms_to_group_sent');
        $black_numbers = array_diff($numbers, $ok_numbers);
        if(count($black_numbers) > 0){
            $sms_to_group_sent = trans('sms_to_group_sent_except', ['numbers' => implode(' , ', $black_numbers)]);
        }
        $numbers = $ok_numbers;
        $input_id = $this->saveInput($request->all());
        event(new \App\Events\SMS\International($input_id, $request->text, $request->line, $numbers, $request->sendOn, false, $request->all()));
        return [
            'result' => 'success',
            'message' => $sms_to_group_sent,
            'reset' => true,
        ];
    }

    public function sendTest(Request $request){
        if($request->has('international')){
            $this->validate($request, [
                'receiver' => ['required','regex:/[0-9]+/', 'max:20'],
            ]);
        } else {
            if(!$request->has('brand')){
                $this->validate($request, [
                    'receiver' => ['required','numeric','regex:/(090|091|092|093|90|91|92|93){1}\d{8}+/'],
                    'line' => $this->lineValidator()
                ]);
            } else {
                $this->validate($request, [
                    'receiver' => ['required','numeric','regex:/(090|091|092|093|90|91|92|93){1}\d{8}+/'],
                    'brand' => 'required|max:35'
                ]);
            }
        }
        $black_numbers = $this->checkBlackList([$request->receiver]);
        if(!count($black_numbers)){
            return[
                'result' => 'exception',
                'errors' => trans('number_in_blacklist', ['number' => $request->receiver]) 
            ];
        }
        $totalCost = $this->controlCredit($request->line, 'test', [$request->receiver], $request->text);
        event(new \App\Events\SMS\SendTestSMS($request->text, $request->receiver, $request->line, $request->brand, $request->international));
        return [
            'result' => 'success',
            'message' => trans('test_message_sent'),
            'reset' => true,
        ];
    }

    public function importGroupSMSContacts(Request $request){
        $file = $request->uploadfile;
        return $this->importContacts($file, 'contacts');
    }

    public function getInfo($id){
        $inputs = \App\SMSInput::findOrFail($id)->inputs;
        return json_decode($inputs, true);
    }


    use \App\Helpers\API\SMS;

    public function retry(){
        if(Auth::user()->role != 2) abort(403);
        $failedMessages = \App\SMS::where('status', '-1')->orderBy('id', 'asc')->get();
        foreach($failedMessages as $message){
            $this->sendSMS($message->reciever, $message->text, $message->sender, $message->id, '0000-00-00 00:00:00', 'singleSMS');
        }
    }

}
