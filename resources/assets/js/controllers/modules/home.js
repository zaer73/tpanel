angular
	.module('inspinia')
	.controller('moduleController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'modules',
			method: 'get'
		}).then(function(res){
			$scope.modules = res.data;
		});

		$scope.disable = function(key, index){
			$http({
				method: 'delete',
				url: 'modules/'+index
			});
			$scope.modules[key].status = -1;
		}

		$scope.enable = function(key, index){
			$http({
				method: 'put',
				url: 'modules/enable/'+index
			});
			$scope.modules[key].status = 0;
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