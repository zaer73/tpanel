<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MapRange;
use App\NumberBank;
use App\Http\Requests;


class MapController extends Controller
{
    
	public function getPolygons()
	{
		
		$allRanges = MapRange::select('polygon', 'rangeid')->get()->toArray();

		$result = [];

		foreach ($allRanges as $range) {

			$rangeArray = json_decode($range['polygon']);

			$polygon = [];

			foreach ($rangeArray as $singleRangeArray) {

				$polygon[] = [
					'lat' => $singleRangeArray[0],
					'lng' => $singleRangeArray[1]
				];

			}

			$result[] = [
				'id' => $range['rangeid'],
				'polygon' => $polygon
			];

		}

		return $result;

	}

	public function postCount(Request $request)
	{

		$selectedRegions = $request->get('regions');

		if (!count($selectedRegions)) return;

		$count = NumberBank::whereIn('polygon', $selectedRegions)->count();

		return $count;

	}

}
