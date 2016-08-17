angular
	.module('inspinia')
	.controller('ticketsController', function($rootScope, $scope, $http, DTOptionsBuilder, $stateParams){
		
		$http({
			url: 'support/tickets',
			method: 'get'
		}).then(function(res){
			$scope.tickets = res.data;
		});

		$scope.createTicketURL = 'support/tickets';
		$scope.answerToTicketURL = 'support/tickets/'+$stateParams.id;

		if($stateParams.id){
			$http({
				url: 'support/tickets/'+$stateParams.id,
				method: 'get'
			}).then(function(res){
				$scope.ticket = res.data;
			})
		}

		$scope.close = function(key, index){
			$http({
				url: 'support/tickets/cancel/'+index,
				method: 'delete'
			});
			$scope.tickets['sent'][key].condition = '-';
			$scope.tickets['sent'][key].status = -1;
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