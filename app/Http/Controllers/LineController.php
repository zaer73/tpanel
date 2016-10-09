<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\Line;
use Auth, Excel, Validator;

class LineController extends Controller
{
    use \App\Helpers\Upload\ExcelImporter;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = ($request->type == 'sms') ? 'sms' : null;
        $lines = $this->getLines($type);
        return $lines;
        // return view('lines.index.' . userRole(Auth::user()))->with(['lines' => $lines]);
    }

    public function toSend($receivers=false){
        $request = app(Request::class);
        if(userRole(Auth::user()) != 'admin'){
            $lines = Auth::user();
            $lines = $lines->lines($receivers);

            if($receivers) $lines = $lines->with(['receivers']);
            $lines = $lines->get();
            if($request->has('rahyab')){
                $lines = collect($lines)->where('rahyab', 1)->toArray();
            }
            return $lines;
        } else {
            $lines = Line::where(function($query) use($receivers) {
                $query = $query->where(function($query){
                    $query->whereUserId(0)
                    ->whereAgentId(0);
                });
                if($receivers) {
                    $query = $query->where('general', 0);
                } else {
                    $query = $query->orWhere('general', 1);
                }
            });
            if($receivers) $lines = $lines->with(['receivers']);
            if($request->has('rahyab')){
                $lines = $lines->whereRahyab(1);
            }
            return $lines->get();
        }
    }

    private function getLines($type=null, $user=null){
        $user = (empty($user)) ? Auth::user() : $user;
        if(isAdmin($user)){
            return Line::with(['user', 'agent'])->get();
        }
        if(isAgent($user)){
            $lines = Line::whereAgentId($user->id);
            if($type == 'sms'){
                $lines = $lines->where('user_id', 0)
                                ->orWhereDate('user_expires_at', '>', 'NOW()');
            }
            $lines = $lines
                ->with(['user', 'agent'])
                ->get();
            return $lines;
        }
        return Line::whereUserId($user->id)->get();
    }

    private function validate_terms($type=''){
        $unique = '';
        if($type == 'create') $unique = '|unique:lines,number';
        return [
            'number' => 'required|regex:/[0-9]/'.$unique,
            'value' => 'regex:/[0-9]/',
            'general' => 'in:0,1'
        ];
    }

    private function validate_terms_agent($type=''){
        // $unique = '';
        // if($type == 'create') $unique = '|unique:lines,number';
        return [
            // 'number' => 'required|regex:/[0-9]/'.$unique,
            'value' => 'regex:/[0-9]/',
            // 'general' => 'in:0,1'
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!isAdmin(Auth::user())) abort('404');
        return view('lines.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isAdmin(Auth::user())) abort('403');
        $this->validate($request, $this->validate_terms('create'));
        Line::create($request->all());
        return [
            'result' => 'success',
            'message' => trans('lines_created_successfully'),
            'reset' => true
        ];
        // return redirect()->route('lines.index')->with('status', trans('lines_created_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::findOrFail($id);
        if(Auth::user()->role != 2 || $user->parent != Auth::id()) abort(403);
        return $this->getLines(null, $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $line = Line::findOrFail($id);
        return $line;

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
        // if(!isAdmin(Auth::user())) abort('403');
        $line = Line::findOrFail($id);
        if(Auth::user()->role == 1)
        {
            $this->validate($request, $this->validate_terms_agent());
            $to_save = array_intersect_key($request->all(), $this->validate_terms_agent());
        } else {
            $this->validate($request, $this->validate_terms());
            $to_save = array_intersect_key($request->all(), $this->validate_terms());
        }
        $line->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('line_updated_successfully')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!isAdmin(Auth::user())) abort('404');
        Line::destroy($id);
        // return redirect()->route('lines.index');
    }

     /**
     * show the page that user can give lines to other user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getToUser($user){
        $user = \App\User::whereId($user)->first();
        if(!$user) abort('404');
        if(Auth::user()->cannot('lineToUser', $user)) abort('403');
        $lines = Line::where('agent_id', 0)->where('user_id', 0)->get();
        return view('lines.to_user')->with(['user' => $user, 'lines' => $lines]);
    }

    public function giftToUser(){
        if(Auth::user()->role == 2){
            return Line::where('agent_id', 0)->where('user_id', 0)->get();
        }
        if(Auth::user()->role == 1){
            return Line::where('agent_id', Auth::id())->where('user_id', 0)->get();
        }
        abort(403);
    }

    /**
     * store information sent by to-user form
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function postToUser(Request $request, $user){
        $user = \App\User::whereId($user)->first();
        if(!$user) abort('403');
        $line = Line::whereId($request->number['id'])->first();
        if(!$line) abort('403');
        $own_type = ($user->role == 1) ? 'agent' : 'user';
        $line->{$own_type . '_id'} = $user->id;
        if($request->has('expires_at')){
            $line->{$own_type.'_expires_at'} = $request->expires_at;
        }
        $line->save();
        // return redirect()->route('lines.toUser', ['user' => $user->id]);
        return [
            'result' => 'success', 
            'message' => trans('saved_successfully'),
            'reset' => true
        ];
    }

    public function getImport(){
        if(Auth::user()->cannot('importLines', new Line)) abort('404');
        return view('lines.import');
    }

    public function postImport(Request $request){
        if(Auth::user()->cannot('importLines', new Line)) abort('403');
        $this->validate($request, [
            'uploadfile' => 'required'
        ]);
        // ->after(function($validation) use ($request){
        //     if($request->has('file') && !$request->file('file')->isValid()){
        //         $validation->errors()->add(trans('lines_import_file'), trans('invalid_file'));
        //     }
        // });
        $filename = str_replace(' ', '_', date('Y-m-d H:i:s'));
        // $extension = $request->file('uploadfile')->getClientOriginalExtension();
        // $filename = $filename . '.' . $extension;
        // $request->file('uploadfile')->move(storage_path('lines/imports'), $filename);
        $results = $this->import($request->file('uploadfile'), 'lines');
        // $results = array_unique($results);
        $numbers = collect($results)->pluck('number')->all();
        $numberKeys = collect($results)->keyBy('number')->toArray();
        $exists = Line::whereIn('number', $numbers)->lists('number')->toArray();
        $new = array_diff($numbers, $exists);
        if(count($new)){
            $insert = [];
            foreach($new as $single_new){
                if(isset($numberKeys[$single_new])){
                    array_push($insert, $numberKeys[$single_new]);
                }
            }
            if(count($insert)){
                Line::insert($insert);
            }
        }
        return [
            'message' => trans('saved_successfully'),
            'success' => true
        ];
    }

    public function getReceivers(){
        $lines = $this->toSend(true);
        return $lines;
    }

    public function getReceiver($id){
        $receiver = \App\SMSReceiver::whereLineId($id)->whereUserId(Auth::id())->first();
        if(!$receiver) abort(404);
        return $receiver;
    }

    public function putReceivers(Request $request, $id){
        $receiver = \App\SMSReceiver::whereLineId($id)->whereUserId(Auth::id())->first();
        $this->validate($request, [
            'redirect_url' => 'required_without:receiver_number|url',
            'receiver_number' => [
                'required_without:redirect_url', 
                'regex:/^(090|091|092|093|90|91|92|93){1}\d{8}$/'
            ]
        ]);
        if(!$receiver) {
            $receiver = new \App\SMSReceiver;
            $receiver->user_id = Auth::id();
            $receiver->line_id = $id;
        }
        $receiver->redirect_url = $request->redirect_url;
        $receiver->receiver_number = $request->receiver_number;
        $receiver->save();
        return [
            'result' => 'success',
            'message' => trans('saved_successfully')
        ];
    }

    public function toggleGeneral(Request $request){
        $line = Line::findOrFail($request->id);
        $line->general = !$line->general;
        $line->save();
    }

    public function toggleShoppable(Request $request){
        $line = Line::findOrFail($request->id);
        $line->shoppable = !$line->shoppable;
        $line->save();
    }

    public function toggleNotifier(Request $request){
        $line = \App\Line::whereAgentId(Auth::id())->whereId($request->line_id)->first();
        if(!$line) abort(404);
        \App\Line::whereAgentId(Auth::id())->whereId($request->line_id)->update([
            'notifier' => 0
        ]);
        $line->notifier = 1;
        $line->save();
    }

    public function toggleOwner(Request $request, $type){
        if($type == 'agent' && Auth::user()->role != 2) abort(403);
        if($type == 'user' && Auth::user()->role == 0) abort(403);
        \App\Line::whereId($request->line_id)->update([
            $type."_id" => 0,
            $type."_expires_at" => '0000-00-00 00:00:00'
        ]);
    }

    public function deleteReceivers($id){
        $received = \App\SMSReceiver::whereLineId($id)->whereUserId(Auth::id())->first();
        if(!$received) abort(403);
        $received->delete();
    }
}
