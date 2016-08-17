<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Module extends Model
{
    protected $fillable = ['module_key', 'value', 'status'];

    protected $appends = ['permission', 'create_date', 'module_title'];

    public function getPermissionAttribute(){
    	$key = $this->attributes['module_key'];
    	return Auth::user()->permissions()->pluck($key);
    }

    public function getCreateDateAttribute(){
    	$created_at = $this->attributes['created_at'];
    	return jalali($created_at);
    }

    public function getModuleTitleAttribute(){
        $module_key = $this->attributes['module_key'];
        return trans('permission_'.$module_key);
    }
}
