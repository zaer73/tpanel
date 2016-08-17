angular
	.module('inspinia')
	.controller('defaultMessagesController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'sms/default-messages',
			method: 'get'
		}).then(function(res){
			$scope.defaultMessages = res.data;
		});

		$scope.delete = function(key, index){
			$scope.defaultMessages.splice(key, 1);
			$http({
				url: 'sms/default-messages/'+index,
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