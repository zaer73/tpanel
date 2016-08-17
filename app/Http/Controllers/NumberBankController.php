<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth, Validator;
use \App\NumberBank as Bank;

class NumberBankController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
        if(Auth::user()->cannot('seeNumbers', new Bank)) abort('404');
        $numbers = Bank::with(['occupation', 'numberProvince', 'numberCity'])->get();
        return $numbers;
    }

    public function getDefine(){
        if(Auth::user()->cannot('defineCities', new Bank)) abort('404');
        $occupations = \App\Occupation::all();
        return view('lines.define.index')->with(['occupations' => $occupations]);
    }

    public function destroy($id){
        $number = Bank::find($id);
        if ($number) {
            $number->delete();
        }
    }

    public function postDefine(Request $request){
        // if(Auth::user()->cannot('defineCities', new Bank)) abort('403');

        $this->validate($request, [
            'province_id' => 'required',
            'city_id' => 'required',
            'job_id' => 'required',
            'postal_code_id' => 'required',
            'gender' => 'required',
            'number' => 'required'
        	// 'province_id' => 'required_with:city_id|required_without_all:job_id,postal_code_id,gender|numeric',
    		// 'city_id' => 'numeric',
    		// 'job_id' => 'required_without_all:province_id,postal_code_id,gender',
    		// 'postal_code_id' => 'required_without_all:province_id,job_id,gender',
    		// 'gender' => 'required_without_all:province_id,job_id,postal_code_id',
    		// 'number' => 'required_without:file|regex:/[0-9]/|unique:number_banks,number',
    		// 'file' => 'required_without:number'
        ]);

        $NumberBank = new Bank;

        if(Bank::whereNumber($request->number)->count('id') > 0)
        {
            return ;
        }

        $NumberBank->number = $request->number;

        $province = \App\Province::where('name', 'like', "%{$request->province_id}%")->first();
        if( $province ){
            $NumberBank->province_id = $province->id;
        }

        $city = \App\City::where('name', 'like', "%{$request->city_id}%")->first();
        if( $city ){
            $NumberBank->city_id = $city->id;
        }

        $occupation = \App\Occupation::where('title', 'like', "%{$request->job_id}%")->first();
        if( $occupation ){
            $NumberBank->job_id = $occupation->id;
        }

        $postal_code = \App\PostalCode::where('title', 'like', "%{$request->postal_code_id}%")->first();
        if( $postal_code ) {
            $NumberBank->postal_code_id = $postal_code->id;
        }
        $NumberBank->gender = ($request->gender == 'مرد') ? 1 : 2;
        return [
            'result' => 'success',
            'message' => trans('number_added_successfully')
        ];
        // return redirect()->route('numbersBank.define.cities')->with('status', 'okay');
    }

    private function upload($request){
    	$filename = str_replace(' ', '_', date('Y-m-d H:i:s'));
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = $filename . '.' . $extension;
        $request->file('file')->move(storage_path('lines/imports'), $filename);
        return $filename;
    }

    private function saveNumbers($results, $request){
    	$bank_temrs = ['province_id','city_id','job_id','postal_code_id','gender'];
    	$results = array_unique($results);
        $exists_query = Bank::whereIn('number', $results)->get();
        $exists = $exists_query->lists('number')->toArray();
        foreach($exists_query as $exist){
        	foreach($bank_temrs as $term){
        		$exist->{$term} = $request->{$term};
        	}
        	$exist->save();
        }
        $new = array_diff($results, $exists);
        if(count($new)){
            $insert = [];
            foreach($new as $single_new){
            	$to_push = ['number' => $single_new];
            	foreach($bank_temrs as $term){
            		$to_push[$term] = $request->{$term};
            	}
                array_push($insert, $to_push);
            }
            Bank::insert($insert);
        }
    }

    public function getOccupation(){
    	if(Auth::user()->cannot('defineOccupations', new Bank)) abort('404');
    	$occupations = \App\Occupation::all();
    	return view('lines.define.occupations')->with(['occupations' => $occupations]);
    }

    public function postOccupation(Request $request){
    	if(Auth::user()->cannot('defineOccupations', new Bank)) abort('403');
    	$this->validate($request, [
    		'number' => 'required|regex:/[0-9]/',
    		'job_id' => 'required|exists:occupations,id'
    	]);
    	Bank::create([
    		'number' => $request->number,
    		'job_id' => $request->job_id
    	]);
    	return redirect()->route('numbersBank.define.occupation');
    }	

    public function apiCities(){
        $numbers = Bank::select('id', 'province_id', 'city_id')->where('province_id', '!=', 0)->where('city_id', '!=', 0)->get();
        $provinces = $numbers->lists('province_id')->toArray();
        $provinces = array_unique($provinces);
        $cities = $numbers->lists('city_id');
        $provinces = \App\Province::whereIn('id', $provinces)->with([
            'cities' => function($query) use ($cities){
                $query->whereIn('id', $cities);
            }])->get();
        return $provinces;
    }

    public function getCount($id){
        $range = 5000;
        $count = Bank::select('id')->where('city_id', $id)->count('id');
        $start = 1;
        $ranges = [0 => ''];
        if(count($count) > 0){
            for($i=0;$i<=floor($count/$range);$i++){
                $ranges[$range*($i+1)] = trans('MAX_SENDING_COUNT_RANGE', ['from' => $range*($i)+1, 'to' => $range*($i+1)]);
            }
        }
        return [
            'ranges' => $ranges,
            'max' => $count
        ];
    }

    public function edit($id){
        return Bank::whereId($id)->first();
    }

    use \App\Helpers\Upload\ExcelImporter;

    public function import(Request $request){
        $rows = $this->importNumbersBank($request->uploadfile);
        foreach($rows as $row){
            $NumberBank = new Bank;
            foreach($row as $col_key => $col_val){
                if($col_key == 'number'){
                    if(Bank::whereNumber($col_val)->count('id') > 0) continue;
                    $NumberBank->number = $col_val;
                }
                if($col_key == 'province'){
                    $province = \App\Province::where('name', 'like', "%{$col_val}%")->first();
                    if( $province ){
                        $NumberBank->province_id = $province->id;
                    }
                }
                if($col_key == 'city'){
                    $city = \App\City::where('name', 'like', "%{$col_val}%")->first();
                    if( $city ){
                        $NumberBank->city_id = $city->id;
                    }
                }
                if($col_key == 'job'){
                    $occupation = \App\Occupation::where('title', 'like', "%{$col_val}%")->first();
                    if( $occupation ){
                        $NumberBank->job_id = $occupation->id;
                    }
                }
                if($col_key == 'postal_code'){
                    $postal_code = \App\PostalCode::where('title', 'like', "%{$col_val}%")->first();
                    if( $postal_code ) {
                        $NumberBank->postal_code_id = $postal_code->id;
                    }
                }
                if($col_key == 'gender'){
                    $NumberBank->gender = ($col_val == 'مرد') ? 1 : 2;
                }
            }
            try{
                $NumberBank->save();
            } catch(\Exception $e){

            }
        }
        return [
            'result' => 'blacklist',
            'message' => trans('saved_successfully')
        ];
    }
}
