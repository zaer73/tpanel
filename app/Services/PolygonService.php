<?php

namespace App\Services;

use App\MapRange;
use Illuminate\Http\Request;

class PolygonService 
{

	public function __construct()
	{

	}

	public function create(Request $request)
	{

		if (json_decode($request->selectedPolygon)) {	
			$polygon = json_decode($request->selectedPolygon);
		} else {
			$polygon = $request->selectedPolygon;
		}
		$polygonToSave = [];

		foreach ($polygon as $singleLatLng) {
			// dd($singleLatLng);
			$polygonToSave[] = [
				$singleLatLng->lat,
				$singleLatLng->lng
			];
		}

		$range = MapRange::create([
			'polygon' => json_encode($polygonToSave)
		]);

		return $range;

	}

}