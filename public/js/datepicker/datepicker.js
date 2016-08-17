'use strict';

/* Controllers */

angular
    .module('inspinia').factory('dateServiceFactory', function(){
	return {
		explodeTime: function(date){
			var obj = {
				hour: date.getHours(),
				minutes: date.getMinutes(),
				seconds: date.getSeconds(),
				year: date.getFullYear(),
				month: date.getMonth(),
				day: date.getDate()
			}
			return this.addZero(obj);
		},
		addZero: function(obj){
			var key;
			for(key in obj){
				if(obj[key].toString().length == 1) {
					if(key == 'month') obj[key]++;
					obj[key] = '0' + obj[key];
				}
			}
			return obj;
		},
		getTimestamp: function(date){
			var timeObj = this.explodeTime(date);
			var string = timeObj.year+'-'+timeObj.month+'-'+timeObj.day+' '+timeObj.hour+':'+timeObj.minutes+':'+timeObj.seconds;
			return string;
		},
		getTimestampFromArray: function(array){
			var key, date, result=[];
			for(key in array){
				date = new Date(array[key]);
				var exploded = this.getTimestamp(date);
				result.push(exploded);
			}
			return result;
		}
	}
});


angular
    .module('inspinia').controller('MultipleDatePickerController', function(dateServiceFactory) {
	this.selectedDates = [new Date().setHours(0, 0, 0, 0)];
	this.timeChanged = function(){
		var selected = this.mytime.setHours(0, 0, 0, 0);
		if(this.selectedDates.indexOf(selected) !== -1){
			var key = this.selectedDates.indexOf(selected);
			this.selectedDates.splice(key, 1);
		} else {
			this.selectedDates.push(selected);
		}
		this.getDate();
	}
	this.removeFromSelected = function(date){
		this.selectedDates.splice(this.selectedDates.indexOf(date), 1);
	}
	this.getDate = function(){
		var result = dateServiceFactory.getTimestampFromArray(this.selectedDates);
		return result;
	}
});


angular
    .module('inspinia').controller('SingleDatePickerController', function(dateServiceFactory, $scope, $rootScope) {
	$scope.showDatepicker = true;
	$rootScope.initialDate = new Date('2016-12-12');
	this.timeChanged = function(){
		this.selectedDates = [this.mytime.setHours(0, 0, 0, 0)];
		$rootScope.DateTimeScope = this.getDate();
	}
	this.getDate = function(){
		return dateServiceFactory.getTimestampFromArray(this.selectedDates)[0];
	}
	this.toggleShow = function(){
		$scope.showDatepicker = !$scope.showDatepicker;
	}
});


angular
    .module('inspinia').controller('TimepickerCtrl', function ($scope, $log) {
	  this.mytime = new Date();

	  $scope.showTimepicker = false;

	  this.toggleShow = function(){
	  	$scope.showTimepicker = !$scope.showTimepicker;
	  }

	  this.hstep = 1;
	  this.mstep = 15;

	  this.options = {
	    hstep: [1, 2, 3],
	    mstep: [1, 5, 10, 15, 25, 30]
	  };

	  this.ismeridian = true;
	  this.toggleMode = function() {
	    this.ismeridian = ! this.ismeridian;
	  };

	  this.update = function() {
	    var d = new Date();
	    d.setHours( 14 );
	    d.setMinutes( 0 );
	    this.mytime = d;
	  };

	  this.changed = function () {
	  	
	  };

	  this.clear = function() {
	    this.mytime = null;
	  };
})

angular
    .module('inspinia').controller('DateTimePickerController', function(dateServiceFactory, $scope){
	this.date = this.time = new Date();

	$scope.showDateTimepicker = false;

	this.toggleShow = function(){
		$scope.showDateTimepicker = !$scope.showDateTimepicker;
	}

	this.dateChanged = function(date){
		var timeObj = dateServiceFactory.explodeTime(this.time)
		this.date = date;
		this.date.setHours(timeObj.hour);
		this.date.setMinutes(timeObj.minutes);
		this.date.setSeconds(timeObj.seconds);
		this.time = this.date;
		this.getDate();
	}
	this.timeChanged = function(time){
		var timeObj = dateServiceFactory.explodeTime(this.date);
		this.time = time;
		this.time.setFullYear(timeObj.year);
		this.time.setMonth(timeObj.month);
		this.time.setDate(timeObj.day);
		this.date = this.time;
		this.getDate();
	}
	this.getDate = function(){
		var string = dateServiceFactory.getTimestamp(this.date);
		return string;
	}
});
