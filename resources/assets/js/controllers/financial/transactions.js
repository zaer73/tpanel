angular
	.module('inspinia')
	.controller('transactionsController', function($rootScope, $scope, $http, DTOptionsBuilder){
			
		$scope.transactions = [];

		$http({
			url: 'financial/transactions',
			method: 'get'
		}).then(function(res){
			$scope.transactions = res.data;
		});

		$scope.dtOptions = DTOptionsBuilder.newOptions()
		    .withDOM('<"html5buttons"B>lTfgitp')
		    .withButtons([
		        {extend: 'copy'},
		        {extend: 'csv'},
		        {extend: 'excel', title: 'ExampleFile'},
		        
		
		        {extend: 'print',
		            customize: function (win){
		                $(win.document.body).addClass('white-bg');
		                $(win.document.body).css('font-size', '10px');
		
		                $(win.document.body).find('table')
		                    .addClass('compact')
		                    .css('font-size', 'inherit');
		            }
		        }
		    ]);

	});	