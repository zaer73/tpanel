<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    protected $fillable = ['title', 'description', 'status'];

    protected $appends = ['select_box', 'actions'];

    public function contacts(){
    	return $this->hasMany('App\Contact', 'group_id', 'id');
    }

    public function getSelectBoxAttribute()
    {
    	return '<input type="checkbox" id="selectAllRows">';
    }

    public function getActionsAttribute()
    {
    	return '<a ui-sref="app.contactsGroups.edit({id: '.$this->id.'})" >
            <i class="fa fa-pencil"></i>
        </a>
        <a href="" ng-click="delete(key,'.$this->id.')">
            <i class="fa fa-remove"></i>
        </a>';
    }
}
