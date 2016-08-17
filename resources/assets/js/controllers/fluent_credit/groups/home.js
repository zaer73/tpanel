angular
	.module('inspinia')
	.controller('fluentCreditHomeController', function($scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'fluent-credits/groups',
			method: 'get'
		}).then(function(res){
			$scope.fluentCreditGroups = res.data;
		});

		$scope.delete = function(key, id){
			$http({
				url: 'fluent-credits/groups/'+id,
				method: 'delete'
			});
			$scope.fluentCreditGroups.splice(key, 1);
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