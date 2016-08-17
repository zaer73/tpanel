angular
	.module('inspinia')
	.controller('dashboardController', function($rootScope, $scope, $http){

		$rootScope.info = [];
		
		$http({
			url: 'dashboard',
			method: 'get'
		}).then(function(res){
			$rootScope.info = res.data;
			$scope.generateChart();
		});

		$http({
			url: 'news',
			method: 'get'
		}).then(function(res){
			$scope.dashboardNews = res.data;
		});

		$http({
			url: 'support/tickets/dashboard',
			method: 'get'
		}).then(function(res){
			$scope.dashboardTickets = res.data;
		});

		$scope.generateChart = function(){
		    var dataset = [
		        {
		            label: "Number of messages",
		            grow:{stepMode:"linear"},
		            data: $rootScope.info.messages_chart,
		            color: "#1ab394",
		            bars: {
		                show: true,
		                align: "center",
		                barWidth: 24 * 60 * 60 * 600,
		                lineWidth: 0
		            }

		        },
		    ];

		    var options = {
		        grid: {
		            hoverable: true,
		            clickable: true,
		            tickColor: "#d5d5d5",
		            borderWidth: 0,
		            color: '#d5d5d5'
		        },
		        colors: ["#1ab394", "#464f88"],
		        tooltip: true,
		        xaxis: {
		            mode: "time",
		            tickSize: [3, "day"],
		            tickLength: 0,
		            axisLabel: "Date",
		            axisLabelUseCanvas: true,
		            axisLabelFontSizePixels: 12,
		            axisLabelFontFamily: 'Arial',
		            axisLabelPadding: 10,
		            color: "#d5d5d5"
		        },
		        yaxes: [
		            {
		                position: "left",
		                max: $rootScope.info.messages_chart_max_val,
		                color: "#d5d5d5",
		                axisLabelUseCanvas: true,
		                axisLabelFontSizePixels: 12,
		                axisLabelFontFamily: 'Arial',
		                axisLabelPadding: 3
		            },
		            {
		                position: "right",
		                color: "#d5d5d5",
		                axisLabelUseCanvas: true,
		                axisLabelFontSizePixels: 12,
		                axisLabelFontFamily: ' Arial',
		                axisLabelPadding: 67
		            }
		        ],
		        legend: {
		            noColumns: 1,
		            labelBoxBorderColor: "#d5d5d5",
		            position: "nw"
		        }

		    };

		    /**
		     * Definition of variables
		     * Flot chart
		     */
		    $scope.flotData = dataset;
		    $scope.flotOptions = options;
		}

	});	