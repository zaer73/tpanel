angular
	.module('inspinia')
	.controller('fluentCreditController', function($scope, $http, DTOptionsBuilder){

		$scope.fluentCredits = [];
		
		$http({
			url: 'fluent-credits',
			method: 'get'
		}).then(function(res){
			$scope.fluentCredits = res.data;
		});

		$scope.delete = function(key, index){
			$scope.fluentCredits.splice(key, 1);
			$http({
				url: 'fluent-credits/'+index,
				method: 'delete'
			});
		}

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