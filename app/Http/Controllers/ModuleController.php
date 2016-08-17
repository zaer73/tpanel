<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Module;
use Cons, Auth;

class ModuleController extends Controller
{

    public function __construct(){
        // $this->middleware('admin');
    }

    private function validate_terms(){
        return [
            'module_key' => 'required',
            'value' => 'required|regex:/[0-9]/'
        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::all();
        return $modules;
        // return view('modules.index')->with(['modules' => $modules]);
    }

    public function api(){
        $available = Cons::$permissions;
        $used = Module::all()->lists('module_key')->toArray();
        return array_diff($available, $used);
    }

    private function getModules($is_edit=false, $edit_module=null){
        $modules = Cons::$permissions;
        $already_added = Module::all()->lists('module_key')->toArray();
        $modules = array_diff($modules, $already_added);
        if($is_edit) array_push($modules, $edit_module);
        return $modules;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = $this->getModules();
        return view('modules.create')->with(['modules' => $modules]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validate_terms());
        $to_save = array_intersect_key($request->all(), $this->validate_terms());
        Auth::user()->modules()->create($to_save);
        return [
            'result' => 'success',
            'message' => trans('module_created'),
            'link' => route('modules.index')
        ];
        // return redirect()->route('modules.index');
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
        $module = Module::whereId($id)->first();
        if(!$module) abort('404');
        return ['module' => $module, 'modules' => $this->getModules(true, $module->module_key)];
        // return view('modules.edit')->with(['module' => $module]);
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
        $module = Module::whereId($id)->first();
        if(!$module) abort('403');
        $this->validate($request, [
            'value' => 'required|regex:/[0-9]/'
        ]);
        $module->update(['value' => $request->value]);
        return [
            'result' => 'success',
            'message' => trans('module_updated')
        ];
        // return redirect()->route('modules.edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::whereId($id)->first();
        if(!$module) abort('403');
        $module->update(['status' => -1]);
        // return redirect()->route('modules.index');
    }

    public function enable($id)
    {
        $module = Module::whereId($id)->first();
        if(!$module) abort('403');
        $module->update(['status' => 0]);
        // return redirect()->route('modules.index');
    }
}
