angular
	.module('inspinia')
	.controller('showPollController', function($rootScope, $scope, $http, $stateParams){

		$http({
			url: 'polls/'+$stateParams.id,
			method: 'get'
		}).then(function(res){
			$scope.flotPieData = res.data;
		});

	    /**
	     * Pie Chart Data
	     */
	    $scope.flotPieData = [
	       
	    ];

	    /**
	     * Pie Chart Options
	     */
	    $scope.flotPieOptions = {
	        series: {
	            pie: {
	                show: true
	            }
	        },
	        grid: {
	            hoverable: true
	        },
	        tooltip: true,
	        tooltipOpts: {
	            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
	            shifts: {
	                x: 20,
	                y: 0
	            },
	            defaultTheme: false
	        }
	    };


	});