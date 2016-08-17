<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Poll;
use Auth, Excel;

class PollController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    private function validate_terms(){
        $user_id = Auth::id();
        $line_id_validation = $this->lineValidation();
        return [
            'title' => 'required|max:50',
            'type' => 'required|in:1,2',
            'line_id' => "required|{$line_id_validation}",
            'started_at' => 'required',
            'finished_at' => 'required',
            'question' => 'required|max:500',
            'answers.0' => 'required|max:50',
            'reply' => 'max:500',
            'answers' => 'required'
        ];
    }

    public function lineValidation($number=false){
        $user = Auth::user();
        $identifier = (!$number) ? 'id' : 'number';
        if(isAdmin($user)){
            return "exists:lines,{$identifier}";
        }
        if(isAgent($user)){
            return "exists:lines,{$identifier},agent_id,{$user->id},user_id,0";
        }
        return "exists:lines,{$identifier},user_id,{$user->id}";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polls = Auth::user()->polls()->whereStatus(0)->get();
        return $polls;
        // return view('polls.index')->with(['polls' => $polls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createPoll', new Poll)) abort('404');
        $lines = $this->getLines();
        return view('polls.create')->with(['lines' => $lines]);
    }

    public function getLines($not_id=[]){
        $user = Auth::user();
        if(isAdmin($user)){
            return \App\Line::whereUserId(0)->whereAgentId(0)->whereNotIn('number', $not_id)->get();
        }
        return Auth::user()->lines()->whereNotIn('number', $not_id)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->cannot('createPoll', new Poll)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $to_save['answer'] = json_encode(array_filter($to_save['answers']));
        Auth::user()->polls()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('poll_created'),
            'reset' => true
        ];
        // return redirect()->route('polls.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poll = Auth::user()->polls()->whereId($id)->first();
        if(!$poll) abort('404');
        return $this->analyze_answers($poll);
    }

    private function analyze_answers($poll){
        $colors = ['#d3d3d3', '#bababa', '#79d2c0', '#1ab394', '#d3d3d3', '#bababa', '#79d2c0', '#1ab394'];
        $replies = $poll->answers()->with(['replies' => function($query){
            $query->select('text', 'id');
        }])->get()->toArray();
        $answers = $poll->answer;
        array_push($answers, 'purge');
        $result = array_fill_keys($answers, 0);
        foreach($replies as $reply){
            foreach($answers as $answer){
                if(preg_match("/{$answer}/", $reply['replies']['text'])){
                    $result[$answer] = $result[$answer]+1;
                } else {
                    $result['purge'] = $result['purge']+1;
                }
            }
        }
        $return = [];
        $count = 0;
        foreach($result as $reply => $value){
            if(!$colors[$count]) return;
            $return[$count]['label'] = $reply;
            $return[$count]['data'] = $value;
            $return[$count]['color'] = $colors[$count];
            $count++;
        }
        return $return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $poll = Poll::whereId($id)->whereStatus(0)->first();
        if(!$poll || Auth::user()->cannot('editPoll', $poll)) abort('404');
        return $poll;
        // $lines = $this->getLines();

        // return view('polls.edit')->with(['poll' => $poll, 'lines' => $lines]);
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
        $poll = Poll::whereId($id)->whereStatus(0)->first();
        if(!$poll || Auth::user()->cannot('editPoll', $poll)) abort('403');
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        $to_save['answer'] = json_encode(array_filter($to_save['answers']));
        $poll->update($to_save);
        return [
            'result' => 'success',
            'message' => trans('poll_updated'),
            'url' => route('polls.edit', ['id' => $id])
        ];
        // return redirect()->route('polls.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poll = Poll::whereId($id)->whereStatus(0)->first();
        if(!$poll || Auth::user()->cannot('deletePoll', $poll)) abort('403');
        $poll->update(['status' => '-1']);
        // return redirect()->route('polls.index');
    }

    public function export($id)
    {

        $data = Poll::whereId($id)->select('id', 'type', 'started_at', 'finished_at', 'answer')->with(['answers.user', 'answers.replies' => function ($query) {
            $query->select('id', 'user_id', 'text', 'created_at');
        }])->first();

        if (!$data) {
            abort(404);
        }

        $data = $data->toArray();

        $export = [
            ['user', 'text', 'date']
        ];
        
        if ( count($data) && isset($data['answers']) ) {
            collect($data['answers'])->each(function ($item, $key) use (&$export) {
                $export[] = [
                    $item['user']['username'],
                    $item['replies']['text'],
                    $item['replies']['created_at']
                ];
            });
        }

        unset($data);

        $filename = 'poll_report_'.date('Y-m-d H:i:s');

        Excel::create($filename, function($excel) use ($export) {

            $excel->sheet('Sheetname', function($sheet) use ($export) {

                $sheet->fromArray($export);

            });

        })->export('xls');

        die();
    }
}
