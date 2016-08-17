<?php
namespace App\Helpers\Upload;

use Auth;

trait ExcelImporter{

	public function import($file, $type){
		$filename = $this->uploadExcel($file, $type);
        $result = [];
        $path = $type.'/imports/' . $filename;
        \Excel::load('storage/' . $path, function($reader) use (&$result){
            $array = $reader->toArray();
            foreach($array as $key => $value){
                if(empty($value['number'])) continue;
                array_push($result, [
                    'number' => (int) $value['number'],
                    'value' => (int) $value['value']
                ]);
            }
        })->get();
        unlink(storage_path($path));
        return $result;
    }

    public function importNumbersBank($file){
        $filename = $this->uploadExcel($file, 'numbers-bank');
        $result = [];
        $path = 'numbers-bank/imports/'.$filename;
        \Excel::load('storage/' . $path, function($reader) use (&$result){
            $array = $reader->toArray();
            foreach($array as $key => $value){
                array_push($result, [
                    'number' => (isset($value['number'])) ? (int) $value['number'] : '', 
                    'province' => (isset($value['province'])) ? $value['province'] : '',
                    'city' => (isset($value['city'])) ?  $value['city'] : '',
                    'postal_code' => (isset($value['postal_code'])) ?  $value['postal_code'] : '',
                    'job' => (isset($value['job_id'])) ?  $value['job_id'] : '',
                    'gender' => (isset($value['gender'])) ? $value['gender'] : '' 
                ]);
            }
        })->get();
        unlink(storage_path($path));
        return $result;
    }

    public function importContacts($file){
    	$filename = $this->uploadExcel($file, 'contacts');
        $result = [];
        $path = 'contacts/imports/' . $filename;
        \Excel::load('storage/' . $path, function($reader) use (&$result){
            $array = $reader->toArray();
            foreach($array as $contact){
            	try{
                    $result[] = $contact['number'];
            		if(!$contact['group']) continue;
            		$group_name = $contact['group'];
            		$group = Auth::user()->contact_groups()->where('title', 'LIKE', "%{$group_name}%")->first();
            		if(!$group) continue;
	            	\Auth::user()->contacts()->create([
	            		'name' => $contact['name'],
	            		'number' => $contact['number'],
	            		'description' => $contact['description'],
	            		'group_id' => $group->id
	            	]);
	            } catch(\Exception $e){
                    echo $e;
	            }
            }
        })->get();
        unlink(storage_path($path));
        return $result;
    }

    protected function uploadExcel($file, $type){
    	$filename = str_random(6);
    	$extension = $file->getClientOriginalExtension();
        $filename = $filename . '.' . $extension;
        $file->move(storage_path($type.'/imports'), $filename);
        return $filename;
    }

}