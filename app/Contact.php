<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['group_id', 'name', 'number', 'trashed', 'description'];

    protected $appends = ['select_box', 'actions', 'trash_actions'];

    public function group(){
    	return $this->belongsTo('\App\ContactGroup', 'group_id', 'id');
    }

    public function getSelectBoxAttribute()
    {
    	return '<input type="checkbox" id="selectAllRows">';
    }

    public function getActionsAttribute()
    {
    	return '<a href="" ng-click="sendMessage(key, contact)">
            <i class="fa fa-paper-plane"></i>
        </a>
        <a ui-sref="app.contacts.edit({id:'.$this->id.'})" ng-click="edit(key, contact.id)">
            <i class="fa fa-pencil"></i>
        </a>
        <a href="" ng-click="delete(key,'.$this->id.')">
            <i class="fa fa-remove"></i>
        </a>';
    }

    public function getTrashActionsAttribute()
    {
    	return '<a href="" ng-click="restore(key, '.$this->id.')">
            <i class="fa fa-recycle"></i>
        </a>
        <a href="" ng-click="explode(key,'.$this->id.')">
            <i class="fa fa-remove"></i>
        </a>';
    }
}
