angular
	.module('inspinia')
	.controller('specialsController', function($rootScope, $scope, $http, DTOptionsBuilder){
		
		$http({
			url: 'specials',
			method: 'get'
		}).then(function(res){
			$scope.specials = res.data;
		});

		$scope.delete = function(key, index){
			$http({
				method: 'delete',
				url: 'specials/'+index
			});
			$scope.specials.splice(key, 1);
		};

		$scope.disable = function(key, index){
			$http({
				method: 'delete',
				url: 'specials/disable/'+index
			});
			$scope.specials[key].status = -1;
		};

		$scope.enable = function(key, index){
			$http({
				method: 'put',
				url: 'specials/enable/'+index
			});
			$scope.specials[key].status = 0;
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