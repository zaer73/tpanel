<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Lawyer;
use App\Http\Requests;
use App\Events\User\LawyerCreated;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lawyersIds = auth()->user()->lawyers()->pluck('user_id')->toArray();
        return User::select('username', 'id')->whereIn('id', $lawyersIds)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, GuestController $guest)
    {
        $guest->storeTypeZero($request);

        $user = new User;
        $user = $this->editUser($user, $request);
        $user->save();

        event(new LawyerCreated($user, $request));

        return [
            'result' => 'success',
            'message' => trans('lawyer_successful_create'),
            'reset' => true
        ];
    }

    private function editUser($user, $request, $isEdit=false)
    {
        $username = (!$isEdit) ? auth()->user()->username.'-'.$request->get('username') : $request->get('username');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->name = $user->first_name.' '.$user->last_name;
        $user->username = $username;
        $user->mobile = $request->get('mobile');
        $user->national_code = $request->get('national_code');
        $user->email = $request->email;
        $user->password = $request->get('password');
        $user->parent = auth()->user()->id;
        $user->role = 0;
        $user->unit_fee = auth()->user()->unit_fee;
        $user->price_groups_id = auth()->user()->price_groups_id;
        $user->fluent_group_id = auth()->user()->fluent_group_id;
        $user->custom_fluent_group = auth()->user()->custom_fluent_group;
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $lawyerId
     * @return \Illuminate\Http\Response
     */
    public function edit($lawyerId)
    {
        if (!Lawyer::whereUserId($lawyerId)->whereParentId(auth()->user()->id)->count()) {
            abort(404);
        }

        return User::whereId($lawyerId)->with('permissions')->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GuestController $guest, $lawyerId)
    {
        // $guest->storeTypeZero($request);
        $user = User::whereId($lawyerId)->with('permissions')->first();

        $user = $this->editUser($user, $request, true);
        $user->save();

        event(new LawyerCreated($user, $request));

        return [
            'result' => 'success',
            'message' => trans('lawyer_updated_successfully'),
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
        //
    }
}
