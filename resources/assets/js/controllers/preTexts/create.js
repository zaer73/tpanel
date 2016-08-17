angular
	.module('inspinia')
	.controller('createPreTextController', function($rootScope, $scope, $http){
		
		$scope.createPreTextURL = 'pre-texts';

		$http({
			url: 'pre-texts/api',
			method: 'get',
		}).then(function(res){
			$scope.groups = res.data;
		});

	});	