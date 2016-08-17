angular
    .module('inspinia')
    .directive('persianDatePicker', function(){

    	return {
    		// templateUrl: 'views/persian-date-picker.html',

    		restrict: 'AEC',

    		replace: true,

    		link: function($scope, element, attrs){

    			jQuery(element).attr('id', "datepicker-"+$scope.datepickerId);

	    		setTimeout(function(){
	    			jQuery("#datepicker-"+$scope.datepickerId).pDatepicker({
	    				timePicker: {
	    					enabled: true,
	    					showMeridian: false
	    				},
	    			});
	    		}, 100);

    		},
    		controller: function($scope){

    			$scope.datepickerId = Math.floor((Math.random() * 10000) + 10000);

    		},
    		scope: {

    		}
    	}

    });