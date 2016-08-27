<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapRange extends Model
{
    
	protected $table = 'irsp_maps_range';

	protected $fillable = [
		'polygon'
	];

	public $timestamps = false;

}
