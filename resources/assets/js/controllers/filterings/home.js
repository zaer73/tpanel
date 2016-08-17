angular
	.module('inspinia')
	.controller('filteringsController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'filterings',
			method: 'get'
		}).then(function(res){
			$scope.filterings = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'filterings/'+index
			});
			$scope.filterings.splice(key, 1);
		};

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