<?php 
namespace App\Helpers\SMS;

trait NextTimeGenerator{

	protected $startTime;

	public function nextTimeGenerator($start_at, $repeat, $clock, $week_day, $month_day, $month){
		$this->startTime = strtotime($start_at);
		if($repeat == 'every six hours' || $repeat == 'هر شش ساعت'){
			return $this->everyXHours(6);
		}
		if($repeat == 'every 12 hours' || $repeat == 'هر دوازده ساعت'){
			return $this->everyXHours(12);
		}
		if($repeat == 'every day' || $repeat == 'هر روز'){
			return $this->everyDay($clock);
		}
		if($repeat == 'every week' || $repeat == 'هر هفته'){
			return $this->weekDay($week_day, $clock);
		}
		if($repeat == 'every month' || $repeat == 'هر ماه'){
			return $this->monthDay($month_day, $clock);
		}
		if($repeat == 'every year' || $repeat == 'هر سال'){
			return $this->yearDay($month, $month_day, $clock);
		}
	}

	protected function everyXHours($hours){
		return $this->nextTimeFormat(strtotime('+'.$hours.' hours', $this->startTime));
	}

	protected function nextTimeFormat($time){
		return date('Y-m-d H:i:s', $time);
	}

	protected function everyDay($clock){
		$tomorrow = strtotime('+1 day', $this->startTime);
		return $this->nextTimeFormat(strtotime($clock, $tomorrow));
	}

	protected function weekDay($week_day, $clock){
		$day = \Cons::$week_days[$week_day];
		return $this->nextTimeFormat(strtotime('next '.$day.' '.$clock, $this->startTime));
	}

	protected function monthDay($month_day, $clock){
		$month = 
			(date('d', $this->startTime) > $month_day) 
			? date('M', strtotime('next month', $this->startTime)) 
			: date('M', strtotime('this month', $this->startTime));
		return $this->nextTimeFormat(strtotime("{$month} {$month_day} {$clock}"));
	}

	protected function yearDay($month, $month_day, $clock){
		$month = \Cons::$monthes[$month];
		return $this->nextTimeFormat(strtotime("{$month} {$month_day} {$clock}", $this->startTime));
	}

}