<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Contact;
use Auth;

class ContactController extends Controller
{

    use \App\Helpers\Upload\ExcelImporter;

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms($is_edit=false){
        $user_id = Auth::id();
        $unique = (!$is_edit) ? "unique:contacts,number,NULL,id,user_id,{$user_id}" : '';
        return [
            'group_id' => "required|numeric|exists:contact_groups,id,user_id,{$user_id}",
            'name' => 'max:50',
            'description' => 'max:250',
            'number' => ["required", 'regex:/(090|091|092|093|90|91|92|93){1}\d{8}+/', "max:25"/*, $unique*/]
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Auth::user()->contacts()->whereTrashed(0)->with(['group'])->get();
        return $contacts;
        // return view('contacts.index')->with(['contacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createContact', new Contact)) abort('404');
        $groups = Auth::user()->contact_groups;
        return view('contacts.create')->with(['groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createContact', new Contact)) abort('403');
        $user_id = Auth::id();
        $this->validate($request, [
            'group_id' => "required|numeric|exists:contact_groups,id,user_id,{$user_id}",
            'contact' => 'required_without:customNumbers',
            'contact.*.name' => 'required_without:customNumbers|max:50',
            'contact.*.number' => ["required_without:customNumbers", "regex:/(090|091|092|093|90|91|92|93){1}\d{8}+/", "max:25",/*"unique:contacts,number,NULL,id,user_id,{$user_id},trashed,!2"*/],
            'description' => 'max:250',
            'customNumbers' => 'required_without:contact'
        ]);
        if(!$request->has('customNumbers')){
            // $contacts = $request->contact;
            $contacts = collect($request->contact)->keyBy('number')->toArray();
            $numbers = array_keys($contacts);
        } else {
            $contacts = str_replace([',', "\n"], '%', $request->customNumbers);
            $contacts = explode('%', $contacts);
            $numbers = array_filter($contacts);
        }
        $already_added = Auth::user()->contacts()->whereIn('number', $numbers)->lists('number')->toArray();
        $already_added = array_unique($already_added);
        $diff = array_diff($numbers, $already_added);
        // if($request->has('customNumbers')){
            // $contacts = $diff;
        // }
        foreach($diff as $contact){
            Auth::user()->contacts()->create([
                'group_id' => $request->group_id,
                'name' => (!$request->has('customNumbers')) ? $contacts[$contact]['name'] : '',
                'number' => (!$request->has('customNumbers')) ? $contacts[$contact]['number'] : $contact,
                'description' => $request->description
            ]);
        }
        $message = trans('contact_create');
        if(count($already_added)){
            $message = trans('contact_create_except', ['numbers' => implode(' , ', $already_added)]);
        }
        return [
            'result' => 'success',
            'message' => $message,
            'reset' => true
        ];
        // return redirect()->route('contacts.contact.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::whereId($id)->whereTrashed(0)->first();
        if(!$contact || Auth::user()->cannot('editContact', $contact)) abort('404');
        $groups = Auth::user()->contact_groups()->get();
        $contact->group = $groups->find($contact->group_id); // find contact's group from user's contact groups ... it costs one less database query 
        return $contact;
        // return view('contacts.edit')->with(['contact' => $contact, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::whereId($id)->whereTrashed(0)->first();
        if(!$contact || Auth::user()->cannot('editContact', $contact)) abort('403');
        $this->validate($request, $this->validate_terms(true));
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $contact->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('contact_updated')
        ];
        // return redirect()->route('contacts.contact.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::whereId($id)->whereTrashed(0)->first();
        if(!$contact || Auth::user()->cannot('deleteContact', $contact)) abort('403');
        $contact->update(['trashed' => 1]);
        // return redirect()->route('contacts.contact.index');
    }

    public function getTrashed(){
        $contacts = Auth::user()->deleted_contacts;
        return $contacts;
        // return view('contacts.trash')->with(['contacts' => $contacts]);
    }

    public function restore($id){
        $trashed = Contact::whereId($id)->whereTrashed(1)->first();
        if(!$trashed || Auth::user()->cannot('restoreContact', $trashed)) abort('403');
        $trashed->update(['trashed' => 0]);
        // return redirect()->route('contacts.trashed');
    }

    public function explode($id){
        $trashed = Contact::whereId($id)->whereTrashed(1)->first();
        if(!$trashed || Auth::user()->cannot('explodeContact', $trashed)) abort('403');
        $trashed->delete();
        // return redirect()->route('contacts.trashed');
    }

    public function import(Request $request){
        $file = $request->uploadfile;
        return $this->importContacts($file, 'contacts');
    }
}
