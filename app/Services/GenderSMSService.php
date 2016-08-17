<?php
namespace App\Services;

use Redis;
use Auth;

class GenderSMSService {

	protected $client;
	private $username = 'gvnmt';
	private $password = '1234567';

	public function __construct(){
		$this->client = new \SoapClient('http://rahyabbulk.ir:8020/WebService/SMSCity.asmx?WSDL', array('trace' => true, 'exceptions' => true));
	}

	public function getProvinces(){
		$redis = Redis::connection();
		if($redis->hget('rahyabbulk', 'provinces')){
			return unserialize($redis->hget('rahyabbulk', 'provinces'));
		}
		$response = $this->client->Province([]);
		$provinces_str = $response->ProvinceResult;
		$result = [];
		$provinces_str = str_replace('</Province>', '', $provinces_str);
		$provinces = array_filter(explode('<Province>', $provinces_str));
		foreach($provinces as $province){
			$id = str_replace('<ID>', '', explode('</ID>', $province)[0]);
			$name = str_replace('</Name>', '', str_replace('<Name>', '', explode('</ID>', $province)[1]));
			$result[$id] = $name;
		}
		$redis->hset('rahyabbulk', 'provinces', serialize($result));
		return $result;
	}

	public function getCities($province){
		$redis = Redis::connection();
		if($redis->hget('rahyabbulk', 'province_'.$province)){
			return unserialize($redis->hget('rahyabbulk', 'province_'.$province));
		}
		$response = $this->client->City([
			'Province_ID' => $province
		]);
		$cities_str = $response->CityResult;
		$result = [];
		$cities_str = str_replace('</City>', '', $cities_str);
		$cities = array_filter(explode('<City>', $cities_str));
		foreach($cities as $city){
			$id = str_replace('<ID>', '', explode('</ID>', $city)[0]);
			$name = str_replace('</Name>', '', str_replace('<Name>', '', explode('</ID>', $city)[1]));
			$result[$id] = $name;
		}
		$redis->hset('rahyabbulk', 'province_'.$province, serialize($result));
		return $result;
	}

	public function getCount($request){
		$response = $this->client->CellCount([
			'Province_ID' => $request->province,
			'City_ID' => $request->city,
			'PrePaid' => $request->sim,
			'Women' => $request->gender,
			'FromBirthYear' => $request->fromAge,
			'ToBirthYear' => $request->toAge,
			'PreNumber' => $request->preNumber
		]);
		return $response->CellCountResult;
	}

	public function sendBulk($request, $total_cost){
		$line = \App\Line::findOrFail($request->line);
		$response = $this->client->doSendCityBulk([
			'Username' => $this->username,
			'Password' => $this->password,
			'ShortCode' => $line->number,
			'Message' => $request->text,
			'SendDateTime' => $request->sendOn,
			'FromRow' => 1,
			'SMSCount' => (int) $request->amount,
			'SortNumber' => (bool) $request->has('sort'),
			'PrePaid' => (int) $request->sim,
			'Province' => (int) $request->province,
			'City' => (int) $request->city,
			'Prefix' => $request->preNumber,
			'Gender' => (int) $request->gender,
			'FromBirthYear' => (int) $request->fromAge,
			'ToBirthYear' => (int) $request->toAge,
			// 'FirstNumber' => (int) $request->first_number, 
			// 'LastNumber' => (int) $request->last_number
		]);
		$returnID = str_replace('</ReturnIDs>', '', explode('<ReturnIDs>', $response->doSendCityBulkResult)[1]);
		$this->saveOnDB($request, $total_cost, $returnID);

		return $returnID;
	}

	private function saveOnDB($request, $total_cost, $returnID){
		$genderSMS = new \App\GenderSMS;
		$genderSMS->text = $request->text;
		$genderSMS->user_id = ($request->has('user_id')) ? $request->get('user_id') : Auth::id();
		$genderSMS->inputs = serialize($request->all());
		$genderSMS->credit = $total_cost;
		$genderSMS->returnId = $returnID;
		$genderSMS->save();
	}

	public function getStatus($returnId){
		$response = $this->client->doGetDelivery([
			'Username' => $this->username,
			'ReturnID' => $returnId
		]);
		return $response->doGetDeliveryResult;
	}

	public function cancel($returnId){
		$response = $this->client->doApprove([
			'Username' => $this->username,
			'ReturnID' => $returnId,
			'Approve' => false
		]);
	}

}