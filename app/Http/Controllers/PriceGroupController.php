<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\PriceGroup as Group;
use Auth, Cons;

class PriceGroupController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function api(){
        return Cons::$price_groups;
    }


    public function index()
    {
        $groups = $this->getPriceGroups();
        if(!$groups) abort('404');
        return $groups;
        // return view('prices.groups.index')->with(['groups' => $groups]);
    }

    private function getPriceGroups(){
        $user = Auth::user();
        if(isAdmin($user)) {
            return Group::whereStatus(0)->get();
        }
        if(isAgent($user)){
            return Group::whereUserId($user->id)->whereStatus(0)->get();
        }
        return false;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->cannot('createPriceGroup', new \App\User)) abort('404');
        $priceGroup = \App\PriceGroup::first();
        return $priceGroup;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $priceGroup = \App\PriceGroup::first();
        return $this->update($request, $priceGroup->id);
        // return redirect()->route('price-group.index');
    }

    private function priceGroupTerms(){
        $price_group_items = Cons::$price_groups;
        $items_terms = array_fill(0, sizeof($price_group_items), 'required|numeric|min:0');
        $price_group_terms = array_combine($price_group_items, $items_terms);
        $price_group_terms['title'] = 'required|max:50';
        $price_group_terms['description'] = 'required|max:250';
        $price_group_terms['tax'] = '';
        $price_group_terms['tax_percent'] = 'numeric';
        $price_group_terms['character_limit'] = 'numeric';
        return $price_group_terms;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return \App\User::findOrFail($id)->price_groups_id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::whereId($id)->first();
        if(!$group || Auth::user()->cannot('editGroup', $group)) abort('404');
        return $group;
        // return view('prices.groups.edit')->with(['group' => $group]);
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
        $price_group_terms = $this->priceGroupTerms();
        $this->validate($request, $price_group_terms);
        $all = $request->all();
        $to_save = array_intersect_key($all, $price_group_terms);
        // $to_save['tax'] = ($to_save['tax'] == 'true') ? 1 : 0;
        Auth::user()->price_groups()->whereId($id)->update($to_save);
        return[
            'result' => 'success',
            'message' => trans('price_group_update_successfully')
        ];
        // return redirect()->route('price-group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::whereId($id)->first();
        if(!$group || Auth::user()->cannot('deleteGroup', $group)) abort('403');
        $group->update(['status' => -1]);
    }

    public function toUser(Request $request, $id){
        $user = \App\User::findOrFail($id);
        if(!(Auth::user()->role == 2) && ( $user->agent_id != Auth::id() && $user->parent != Auth::id() )) abort(403);
        if($request->has('priceGroup')){
           $user->update([
                'fluent_group_id' => $request->priceGroup
            ]);
        }
        if($request->has('customCreditFluent') && count($request->get('customCreditFluent'))){
            $groupHash = rand(1000000, 9999999);
            $user->userCustomFluentCredit()->delete();
            foreach($request->get('customCreditFluent') as $credit){
                if(!empty($credit['ceil']) && !empty($credit['fee'])){
                    $user->userCustomFluentCredit()->create([
                        'ceil' => $credit['ceil'],
                        'fee' => $credit['fee'],
                        'group_hash' => $groupHash
                    ]);
                }
            }
            $user->custom_fluent_group = $groupHash;
        } else {
            $user->custom_fluent_group = 0;
        }
        $user->save();
        return [
            'result' => 'success',
            'message' => trans('profile_updated')
        ];
    }
}
