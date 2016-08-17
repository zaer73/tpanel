angular
	.module('inspinia')
	.controller('sendFromMobileHomeController', function($scope, $http, DTOptionsBuilder){
		$http({
			url: 'send-from-mobile',
			method: 'get'
		}).then(function(res){
			$scope.sendFromMobiles = res.data; 
		});

		$scope.delete = function(key, id){
			$http({
				url: 'send-from-mobile/'+id,
				method: 'delete'
			});
			$http({
				url: 'send-from-mobile',
				method: 'get'
			}).then(function(res){
				$scope.sendFromMobiles = res.data; 
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